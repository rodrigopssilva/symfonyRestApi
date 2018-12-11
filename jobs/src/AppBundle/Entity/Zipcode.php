<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Zipcode
 *
 * @category Builder
 * @package  AppBundle\Entity
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ZipcodeRepository")
 */
class Zipcode implements EntityInterface
{
    /**
     * Stores the zipcode
     *
     * @var String
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=5, options={"fixed" = true}, unique=true, nullable=false)
     * @Assert\Length(
     *      min = 5,
     *      max = 5,
     *      minMessage = "The id must have exactly 5 characters",
     *      maxMessage = "The id must have exactly 5 characters"
     * )
     * @Assert\NotBlank()
     */
    private $id;

    /**
     * Stores the name of the city
     *
     * @var String
     *
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "The city must have at least 5 characters",
     *      maxMessage = "The city must have less than 256 characters"
     * )
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * Zipcode constructor.
     *
     * @param String|null $id
     * @param String|null $city
     */
    public function __construct(String $id = null, String $city = null)
    {
        $this->id = $id;
        $this->city = $city;
    }

    /**
     * Returns the stored value in $id attribute
     *
     * @return String|null
     */
    public function getId(): ?String
    {
        return $this->id;
    }

    /**
     * Returns the stored value in $city attribute
     *
     * @return String|null
     */
    public function getCity(): ?String
    {
        return $this->city;
    }
}
