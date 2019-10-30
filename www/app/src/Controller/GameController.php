<?php

namespace App\Controller;

use App\Entity\SourcesInfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use App\Entity\Game;
use App\Entity\Teams;
use App\Entity\Ligues;
use App\Entity\Sports;
use App\Entity\Params;
use App\Entity\ImportLog;
use App\Entity\GameBuffer;


class GameController extends AbstractController
{

    /**
     *  Класс с бизнес-логикой API
     */


    public function putGame($buffer)
    {

        // Получаем данные источника информации
        $source = $this->findSource($buffer['SourceInfo']);

        // Нормазизуем время учитывая смещение источника
        $this->normalizeTime($buffer['StartGame'], $source['time_offset']);

        $game = $this->findGame($buffer);
        if (empty($game)) {
            // Игра не найдена - Добавляем игру
            $game = $this->addGame($buffer);
        }
        if (!empty($game)) {
            // Будем связывать игру с буфером
            return array('id' => $game[0]['id'], 'source_id' => $source['id']);
        }

    }

    /**
     * Метод поиска игры по параметрам из буферной таблицы, если игра найдена - возвращаем список ID
     * @param $buffer
     * @return array|null
     */
    private function findGame($buffer): ?array
    {
        $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
        $qb->select('g.id');
        $qb->from(Game::class, 'g');
        $qb->innerJoin(Teams::class, 't1', 'g.teams1_id = t1.id OR g.teams2_id = t1.id');
        $qb->innerJoin(Teams::class, 't2', 'g.teams1_id = t2.id OR g.teams2_id = t2.id');
        $qb->innerJoin(Ligues::class, 'l', 't1.ligues_id=l.id AND t2.ligues_id=l.id');
        $qb->innerJoin(Sports::class, 's', 'l.sports_id=s.id');
        $qb->innerJoin(Params::class, 'p1', 's.id=p1.sports_id');
        $qb->innerJoin(Params::class, 'p2', 'l.id=p2.ligues_id');
        $qb->innerJoin(Params::class, 'p3', 't1.id=p3.teams_id');
        $qb->innerJoin(Params::class, 'p4', 't2.id=p4.teams_id');
        $qb->andWhere($qb->expr()->eq('p1.name', $qb->expr()->literal($buffer['Sport'])));
        $qb->andWhere($qb->expr()->eq('p2.name', $qb->expr()->literal($buffer['Ligue'])));
        $qb->andWhere($qb->expr()->eq('p3.name', $qb->expr()->literal($buffer['Team1'])));
        $qb->andWhere($qb->expr()->eq('p4.name', $qb->expr()->literal($buffer['Team2'])));
        $qb->andWhere($qb->expr()->eq('g.game_time', $qb->expr()->literal($buffer['StartGame'])));
        $qb->groupBy('g.id');
        $query = $qb->getQuery();

        return $query->getResult();
    }

    /**
     * Метод получает ID команды из справочника
     * @param $team - поле с именем команды
     * @param $buffer
     * @return mixed
     */
    private function getTeamId($team, $buffer)
    {
        $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
        $qb->select('p3.teams_id');
        $qb->from(Teams::class, 't');
        $qb->innerJoin(Params::class, 'p3', 't.id=p3.teams_id');
        $qb->innerJoin(Params::class, 'p2', 'l.id=p2.ligues_id');
        $qb->innerJoin(Params::class, 'p1', 's.id=p1.sports_id');
        $qb->innerJoin(Ligues::class, 'l', 't.ligues_id=l.id');
        $qb->innerJoin(Sports::class, 's', 'l.sports_id=s.id');

        $qb->andWhere($qb->expr()->eq('p3.name', $qb->expr()->literal($team)));
        $qb->andWhere($qb->expr()->eq('p2.name', $qb->expr()->literal($buffer['Ligue'])));
        $qb->andWhere($qb->expr()->eq('p1.name', $qb->expr()->literal($buffer['Sport'])));
        $qb->groupBy('p3.teams_id');
        $query = $qb->getQuery();

        $result = $query->getResult();
        if (!empty($result)) {
            return $result[0]['teams_id'];
        }
    }

    /**
     * Метод получения ID лиги из справочника по параметрам из буферной таблицы
     * @param $buffer
     * @return array|null
     */
    private function findLigue($buffer): ?array
    {
        $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
        $qb->select('l.id ');
        $qb->from(Ligues::class, 'l');
        $qb->innerJoin(Sports::class, 's', 'l.sports_id=s.id');
        $qb->innerJoin(Params::class, 'p1', 's.id=p1.sports_id');
        $qb->innerJoin(Params::class, 'p2', 'l.id=p2.ligues_id');
        $qb->andWhere($qb->expr()->eq('p1.name', $qb->expr()->literal($buffer['Sport'])));
        $qb->andWhere($qb->expr()->eq('p2.name', $qb->expr()->literal($buffer['Ligue'])));
        $qb->groupBy('l.id');
        $query = $qb->getQuery();

        return $query->getResult();
    }

    /**
     * Метод получения ID вида спорта из справочника по параметрам из буферной таблицы
     * @param $buffer
     * @return array|null
     */
    private function findSport($buffer): ?array
    {
        $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
        $qb->select('s.id ');
        $qb->from(Sports::class, 's');
        $qb->innerJoin(Params::class, 'p1', 's.id=p1.sports_id');
        $qb->andWhere($qb->expr()->eq('p1.name', $qb->expr()->literal($buffer['Sport'])));
        $qb->groupBy('s.id');
        $query = $qb->getQuery();

        return $query->getResult();
    }

    /**
     * Метод получает ID и смещение времени по инени источника, если источник не найден, он создается
     * @param string $sourceName
     * @return array|null
     */
    private function findSource(string $sourceName): ?array
    {

        $result = $this->getDoctrine()
            ->getRepository(SourcesInfo::class)
            ->findBy(array('name' => $sourceName));
        if (!empty($result)) {
            $result = array('id' => $result[0]->getId(), 'time_offset' => $result[0]->getTimeOffset());
        }
        if (empty($result)) {
            $em = $this->getDoctrine()->getManager();
            // Создадим источник и поставим значения по умолчанию
            $dt = new SourcesInfo();
            $dt->setName($sourceName);
            $dt->setTimeOffset(0);
            $em->persist($dt);
            $em->flush();
            $result = array(
                'id' => $dt->getId(),
                'time_offset' => 0
            );
        }

        return $result;
    }


    /**
     * Создаем новую игру
     * @return array
     */
    private function addGame($buffer)
    {
        $em = $this->getDoctrine()->getManager();
        $dt = new Game();
        $dt->setTeams1Id($this->getTeamId($buffer['Team1'], $buffer));
        $dt->setTeams2Id($this->getTeamId($buffer['Team2'], $buffer));
        $dt->setGameTime($buffer['StartGame']);
        $em->persist($dt);
        $em->flush();
        return array(array('id' => $dt->getId()));
    }

    /**
     * Нормализация даты с учетом смещения от источников
     * @param int $hour
     * @return false|string
     */
    private function normalizeTime(&$startrgame, $hour = 0): void
    {
        $time = strtotime($startrgame) + ($hour * 3600);
        $startrgame = date('Y-m-d H:i:s', $time);
    }

    /**
     * Парсер из буферной таблицы игр
     */
    public function parserBuffer()
    {
        $em = $this->getDoctrine()->getManager();
        $repolist = $em->getRepository(GameBuffer::class)
            ->findBy(array('source_id' => null));
        foreach ($repolist as $gb) {
            $buffer = array(
                'SourceInfo' => $gb->getSourceInfo(),
                'Sport' => $gb->getSport(),
                'Ligue' => $gb->getLigue(),
                'Team1' => $gb->getTeam1(),
                'Team2' => $gb->getTeam2(),
                'StartGame' => $gb->getStartGame(),
                'Id' => $gb->getId()
            );

            $game = $this->putGame($buffer);
            $gb->setGameId($game['id']);
            $gb->setSourceId($game['source_id']);
            $em->flush();

        }
    }

}
