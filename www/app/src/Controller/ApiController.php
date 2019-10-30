<?php

namespace App\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\GameBuffer;
//use App\Entity\Game;



class ApiController extends GameController
{
    private $error = false;

    /**
     * @Rest\Get("/api/games", name="get_games")
     */
    public function getGames()
    {
        $amount = 1;
        $em = $this->getDoctrine()->getEntityManager();


        $rows = $em->createQuery('SELECT COUNT(u.id) FROM App\Entity\Game u')->getSingleScalarResult();

        $offset = max(0, rand(0, $rows - $amount - 1));


        $query = $em->createQuery('
                SELECT DISTINCT u, (SELECT COUNT(gb.id) FROM App\Entity\GameBuffer gb WHERE gb.game_id=u.id) buffer_count
                FROM App\Entity\Game u')
            ->setMaxResults($amount)
            ->setFirstResult($offset);

        $result = $query->getResult();


        //$games = $this->getDoctrine()->getRepository(GameBuffer::class)->findAll();
        return $this->json($result);
    }

    /**
     * @Rest\Post("/api/games", name="post_games")
     */
    public function setBuffer()
    {
        $json = file_get_contents("php://input");
        $result = [];
        $info = [];

        $em = $this->getDoctrine()->getManager();  //getRepository(GameBuffer::class);
        $error = false;
        if (!empty($json)) {
            $json = json_decode($json, true);

            if (is_array($json)) {
                foreach ($json as &$item) {
                    $item['Hash'] = $this->createHash($item);
                    $find = $this->getDoctrine()
                        ->getRepository(GameBuffer::class)
                        ->findBy(array('hash' => $item['Hash']));
                    if (!empty($find)) {
                        $item['Id'] = $find[0]->getId();
                        $info[] = $item;
                        continue;
                    }

                    $gB = new GameBuffer();
                    $this->setValue('Lang', $item, $gB);
                    $this->setValue('Sport', $item, $gB);
                    $this->setValue('Ligue', $item, $gB);
                    $this->setValue('Team1', $item, $gB);
                    $this->setValue('Team2', $item, $gB);
                    $this->setValue('StartGame', $item, $gB);
                    $this->setValue('SourceInfo', $item, $gB);
                    $this->setValue('Hash', $item, $gB);
                    if (!$this->error) {
                        $em->persist($gB);
                        $em->flush();
                        $item['Id'] = $gB->getId();
                    }
                }
            }
        }
        if (!$this->error) {
            $result['status'] = 'Ok';
            if (!empty($info))
                $result['doubles'] = $info;
            $result['result'] = $json;


        } else {
            $result['status'] = 'Error';
        }
        $this->parserBuffer();

        return $this->json($result);
    }

    /**
     * Метод валидации и добавления записей в таблицу для выполнения INSERT
     * @param string $fieldname
     * @param array $item
     * @param GameBuffer $gb
     */
    private function setValue(string $fieldname, array $item, GameBuffer &$gb): void
    {
        if (!$this->error && !empty($item[$fieldname])) {
            $className = 'set' . $fieldname;
            $gb->$className($item[$fieldname]);
        } else {
            $this->error = true;
        }
    }

    /**
     * Метод создает хэш для исключения дублирующих запичей при импорте в базу
     * @param array $item
     * @return string
     */
    private function createHash(array $item): string
    {
        $word = '';
        foreach ($item as $it => $val) {
            $word .= $val;
        }
        return md5($word);
    }
}
