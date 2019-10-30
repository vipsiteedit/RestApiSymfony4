<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParamsRepository")
 */
class Params
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sports_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ligues_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $teams_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $langs_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSportsId(): ?int
    {
        return $this->sports_id;
    }

    public function setSportsId(int $sports_id): self
    {
        $this->sports_id = $sports_id;

        return $this;
    }

    public function getLiguesId(): ?int
    {
        return $this->ligues_id;
    }

    public function setLiguesId(?int $ligues_id): self
    {
        $this->ligues_id = $ligues_id;

        return $this;
    }

    public function getTeamsId(): ?int
    {
        return $this->teams_id;
    }

    public function setTeamsId(?int $teams_id): self
    {
        $this->teams_id = $teams_id;

        return $this;
    }

    public function getLangsId(): ?int
    {
        return $this->langs_id;
    }

    public function setLangsId(?int $langs_id): self
    {
        $this->langs_id = $langs_id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
