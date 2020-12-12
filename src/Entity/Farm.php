<?php

namespace App\Entity;

use App\Repository\FarmRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Farm
 *
 * @package App\Entity
 * @ORM\Entity(repositoryClass=FarmRepository::class)
 */
class Farm
{
    /**
     * Identifiant unique
     *
     * @var                     Uuid
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    protected $id;

    /**
     * Nom de la ferme
     *
     * @var string|null Nom de la ferme
     * @ORM\Column(nullable=true)
     * @Assert\NotBlank
     */
    protected $name = null;

    /**
     * Nom de la ferme
     *
     * @var string|null Nom de la ferme
     * @ORM\Column(nullable=true)
     * @Assert\NotBlank
     */
    protected $description = null;

    /**
     * @var Producer
     * @ORM\OneToOne(targetEntity="Producer", mappedBy="farm")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $producer;

    /**
     * Getter id
     *
     * @return Uuid
     */
    public function getIid(): Uuid
    {
        return $this->id;
    }

    /**
     * Setter id
     *
     * @param Uuid $id identifiant unique
     *
     * @return Farm
     */
    public function setId(Uuid $id): Farm
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Getter nom de la ferme
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter nom de la ferme
     *
     * @param string|null $name Nom de la feme
     *
     * @return Farm
     */
    public function setName(?string $name): Farm
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Getter producteur
     *
     * @return Producer
     */
    public function getProducer(): Producer
    {
        return $this->producer;
    }

    /**
     * Setter producteur
     *
     * @param Producer $producer Producteur
     *
     * @return Farm
     */
    public function setProducer(Producer $producer): Farm
    {
        $this->producer = $producer;

        return $this;
    }

    /**
     * Getter description
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Setter description
     *
     * @param string|null $description Description
     *
     * @return Farm
     */
    public function setDescription(?string $description): Farm
    {
        $this->description = $description;

        return $this;
    }
}
