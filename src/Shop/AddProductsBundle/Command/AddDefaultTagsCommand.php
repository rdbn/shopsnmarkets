<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 25.10.15
 * Time: 13:47
 */

namespace Shop\AddProductsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Shop\AddProductsBundle\Entity\HashTags;

class AddDefaultTagsCommand extends ContainerAwareCommand
{
    /**
     * @var array
     */
    private $tags = [
        "Мода и стиль",
        "Детская мода",
        "Внешний вид",
        "Макияж",
        "Прическа",
        "Маникюр",
        "Туфли",
        "Кроссовки",
        "Ювелирные изделия",
        "Серьги",
        "Браслеты",
        "Пирсинг",
        "Татуировки",
        "Спорт",
        "Фитнес",
        "Бодибилдинг",
        "Бег",
        "Гимнастика",
        "Йога",
        "Танцы",
        "Футбол",
        "Хоккей",
        "Природа",
        "Пляж",
        "Рассвет и закат",
        "Цветы",
        "Солнце",
        "Облака и Небо",
        "Дождь",
        "Снег",
        "Весна",
        "Лето",
        "Осень",
        "Зима",
        "Праздник",
        "День рождения",
        "Свадьба",
        "Отпуск",
        "Новый год и Рождество",
        "Хэллоуин",
    ];

    protected function configure()
    {
        $this->setName('add:tags')
            ->setDescription('Добавляем список тегов.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");

        foreach ($this->tags as $value) {
            $hash = new HashTags();
            $hash->setName($value);

            $em->persist($hash);
        }

        $em->flush();
    }
}