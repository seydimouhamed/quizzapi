<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReponseRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ReponseRepository::class)
 */
class Reponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"qtn:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"qtn:read"})
     */
    private $libeller;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"qtn:read"})
     */
    private $isCorrect;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="reponses")
     */
    private $question;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibeller(): ?string
    {
        return $this->libeller;
    }

    public function setLibeller(string $libeller): self
    {
        $this->libeller = $libeller;

        return $this;
    }

    public function getIsCorrect(): ?bool
    {
        return $this->isCorrect;
    }

    public function setIsCorrect(bool $isCorrect): self
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
