<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImportLogRepository")
 */
class ImportLog
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
    private $game_buffer_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $game_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $source_info_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameBufferId(): ?int
    {
        return $this->game_buffer_id;
    }

    public function setGameBufferId(int $game_buffer_id): self
    {
        $this->game_buffer_id = $game_buffer_id;

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

    public function getSourceInfoId(): ?int
    {
        return $this->source_info_id;
    }

    public function setSourceInfoId(int $source_info_id): self
    {
        $this->source_info_id = $source_info_id;

        return $this;
    }
}
