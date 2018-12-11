<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Datetime;

/**
 * Class Job
 *
 * @category Repository
 * @package  AppBundle\Entity
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JobRepository")
 */
class Job implements EntityInterface
{
    /**
     * Stores the identifier code of the job
     *
     * @var String|null
     *
     * @ORM\Id()
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * Stores the identifier code of the service
     *
     * @var int|null
     *
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Service")
     * @ORM\JoinColumn(nullable=false, name="service_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $service_id;

    /**
     * Stores the zipcode related to the job
     *
     * @var String|null
     *
     * @ORM\Column(type="string", length=5, options={"fixed" = true})
     * @ORM\ManyToOne(targetEntity="App\Entity\Zipdcode")
     * @ORM\JoinColumn(nullable=false, name="category_id", referencedColumnName="id")
     * @Assert\Length(
     *      min = 5,
     *      max = 5,
     *      minMessage = "The zipcode_id must have exactly 5 characters",
     *      maxMessage = "The zipcode_id must have exactly 5 characters"
     * )
     * @Assert\NotBlank()
     */
    private $zipcode_id;

    /**
     * Stores the title of the job
     *
     * @var String|null
     *
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "The title must more than 4 characters",
     *      maxMessage = "The title must have less than 51 characters"
     * )
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * Stores the description of the job
     *
     * @var String|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * Stores when the job needs to be done.
     *
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(type="date")
     * @Assert\Date()
     */
    private $date_to_be_done;

    /**
     * Stores when the job was created
     *
     * @var Datetime|\DateTimeInterface|null
     *
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * Job constructor.
     *
     * @param int|null $serviceId
     * @param String|null $zipcodeId
     * @param String|null $title
     * @param String|null $description
     * @param \DateTimeInterface|null $dateToBeDone
     * @param String|null $id
     * @param \DateTimeInterface|null $createdAt
     *
     * @throws \Exception
     */
    public function __construct(
        int $serviceId = null,
        String $zipcodeId = null,
        String $title = null,
        String $description = null,
        \DateTimeInterface $dateToBeDone = null,
        String $id = null,
        \DateTimeInterface $createdAt = null
    ) {
        $this->service_id = $serviceId;
        $this->zipcode_id = $zipcodeId;
        $this->title = $title;
        $this->description = $description;
        $this->date_to_be_done = $dateToBeDone;
        $this->created_at = $createdAt ?? new DateTime();
        $this->id = $id ?? $this->id;
    }

    /**
     * This method returns the identifier code of the Job
     *
     * @return mixed|String|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * This method returns the identifier code of the Service
     *
     * @return int|null
     */
    public function getServiceId(): ?int
    {
        return $this->service_id;
    }

    /**
     * This method returns the zipcode
     *
     * @return null|String
     */
    public function getZipcodeId(): ?String
    {
        return $this->zipcode_id;
    }

    /**
     * This method returns the title of the job
     *
     * @return null|String
     */
    public function getTitle(): ?String
    {
        return $this->title;
    }

    /**
     * This method returns the description of the job
     *
     * @return null|String
     */
    public function getDescription(): ?String
    {
        return $this->description;
    }

    /**
     * This method returns when the job needs to be done
     *
     * @return \DateTimeInterface|null
     */
    public function getDateToBeDone(): ?\DateTimeInterface
    {
        return $this->date_to_be_done;
    }

    /**
     * This method returns when the job was created
     *
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }
}
