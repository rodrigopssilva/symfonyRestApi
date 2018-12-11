<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Service
 *
 * @category Repository
 * @package  AppBundle\Entity
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceRepository")
 */
class Service implements EntityInterface
{
    /**
     * Stores the identifier code of the service
     *
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="integer", unique=true, nullable=false)
     * @Assert\NotBlank()
     */
    private $id;

    /**
     * Stores the name of the service
     *
     * @var String|null
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "The name must have at least 5 characters",
     *      maxMessage = "The name must have less than 256 characters"
     * )
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * Service constructor.
     *
     * @param int|null    $id
     * @param String|null $name
     */
    public function __construct(int $id = null, String $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Returns the identifier code of the service.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Returns the name of the service
     *
     * @return String|null
     */
    public function getName(): ?String
    {
        return $this->name;
    }
}
