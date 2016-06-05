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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
     * @Route("/friends/add/{id}", name="add_friends", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     *
     * @return string
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
     * @Route("/friends/add/check/{type}/{user}", name="check_friends", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     *
     * @return string
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
     *     description="Удалить из друзей",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $id
     *
     * @Route("/friends/remove/{id}", name="remove_friends", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     *
     * @return string
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
     * @Route("/friends/result/search", name="result_search", defaults={"_format": "json"})
     * @Method({"GET", "POST"})
     *
     * @Rest\View()
     *
     * @return mixed
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

            $avalancheService = $this->get('liip_imagine.cache.manager');
            $result = array_map(function ($data) use ($avalancheService) {
                $data["path"] = $avalancheService->getBrowserPath($data["path"], 'avatar');
                return $data;
            }, $result);

            return $result;
        }

        return $form->getErrors();
    }
}