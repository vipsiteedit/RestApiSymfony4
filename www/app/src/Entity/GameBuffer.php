<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameBufferRepository")
 */
class GameBuffer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $lang;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sport;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ligue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $team1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $team2;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $start_game;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $source_info;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $hash;

    /**
     * @ORM\Column(type="integer", length=20)
     */
    private $game_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $source_id;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    public function getSport(): ?string
    {
        return $this->sport;
    }

    public function setSport(string $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    public function getLigue(): ?string
    {
        return $this->ligue;
    }

    public function setLigue(string $ligue): self
    {
        $this->ligue = $ligue;

        return $this;
    }

    public function getTeam1(): ?string
    {
        return $this->team1;
    }

    public function setTeam1(string $team1): self
    {
        $this->team1 = $team1;

        return $this;
    }

    public function getTeam2(): ?string
    {
        return $this->team2;
    }

    public function setTeam2(string $team2): self
    {
        $this->team2 = $team2;

        return $this;
    }

    public function getStartGame(): ?string
    {
        return $this->start_game;
    }

    public function setStartGame(string $start_game): self
    {
        $this->start_game = $start_game;

        return $this;
    }

    public function getSourceInfo(): ?string
    {
        return $this->source_info;
    }

    public function setSourceInfo(string $source_info): self
    {
        $this->source_info = $source_info;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getGameId(): ?int
    {
        return $this->game_id;
    }

    public function setGameId(int $game_id): self
    {
        $this->game_id = $game_id;

        return $this;
    }

    public function getSourceId(): ?int
    {
        return $this->source_id;
    }

    public function setSourceId(int $source_id): self
    {
        $this->source_id = $source_id;

        return $this;
    }
}
