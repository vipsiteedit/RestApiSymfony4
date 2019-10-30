<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $teams1_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $teams2_id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $game_time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeams1Id(): ?int
    {
        return $this->teams1_id;
    }

    public function setTeams1Id(int $teams1_id): self
    {
        $this->teams1_id = $teams1_id;

        return $this;
    }

    public function getTeams2Id(): ?int
    {
        return $this->teams2_id;
    }

    public function setTeams2Id(int $teams2_id): self
    {
        $this->teams2_id = $teams2_id;

        return $this;
    }

    public function getGameTime(): ?string
    {
        return $this->game_time;
    }

    public function setGameTime(string $game_time): self
    {
        $this->game_time = $game_time;

        return $this;
    }
}
