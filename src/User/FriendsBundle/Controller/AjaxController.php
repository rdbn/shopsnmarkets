<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\FriendsBundle\Controller;

use User\FriendsBundle\Form\Type\SearchType;

use User\UserBundle\Entity\Users;
use User\FriendsBundle\Entity\Friends;

use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;

class AjaxController extends FOSRestController
{
    /**
     * @ApiDoc(
     *     description="Добавить в друзья",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $id
     *
     * @Rest\View()
     */
    public function addAction($id)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $friendsUser = $em->getRepository('UserUserBundle:Users')
            ->findOneById($id);

        $friends = new Friends();
        $friends->setFriends($friendsUser);
        $friends->setUsers($user);

        $em->persist($friends);
        $em->flush();
        
        return 'successful';
    }

    /**
     * @ApiDoc(
     *     description="Подтвердить добавление в друзья",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $type
     * @param int $user
     *
     * @Rest\View()
     */
    public function checkAction($type, $user)
    {
        $users = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $type = $em->getRepository('UserFriendsBundle:TypeFriends')
            ->findOneById($type);

        $friendsUser = $em->getRepository('UserUserBundle:Users')
            ->findOneById($user);

        /* @var Friends $userFriends */
        $userFriends = $em->getRepository('UserFriendsBundle:Friends')
            ->findOneBy(["users" => $user, "friends" => $users->getId()]);

        $userFriends->setCheckFriends(true);

        $friends = new Friends();
        $friends->setFriends($friendsUser);
        $friends->setUsers($users);
        $friends->setTypeFriends($type);
        $friends->setCheckFriends(true);

        $em->persist($friends);
        $em->flush();

        return 'successful';
    }

    /**
     * @ApiDoc(
     *     description="Удалить из друга",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $id
     *
     * @Rest\View()
     */
    public function removeAction($id)
    {
        $userID = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();
        $friends = $em->getRepository("UserFriendsBundle:Friends")
            ->findOneBy(["id" => $id, "users" => $userID]);

        $em->remove($friends);

        $friends = $em->getRepository("UserFriendsBundle:Friends")
            ->findOneBy(["id" => $userID, "users" => $id]);

        $em->remove($friends);
        $em->flush();

        return 'successful';
    }

    /**
     * @ApiDoc(
     *     description="Поиск пользователей",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     *
     * @Rest\View()
     */
    public function searchAction(Request $request)
    {
        $id = $this->getUser()->getId();

        $users = new Users();
        $form = $this->createForm(new SearchType(), $users);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $search = $this->get("search.users");
            $result = $search
                ->setKeywords($users->getRealname())
                ->setCityId($users->getCity())
                ->setUserId($id)
                ->getResult();

            $count = count($result);
            $avalancheService = $this->get('liip_imagine.cache.manager');
            for ($i = 0; $i < $count; $i++) {
                $result[$i]["path"] = $avalancheService->getBrowserPath($result[$i]["path"], 'avatar');
            }

            return $result;
        }

        return $form->getErrors();
    }
}