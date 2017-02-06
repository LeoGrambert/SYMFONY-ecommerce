<?php

namespace LG\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Date;


/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="LG\CoreBundle\Repository\ClientRepository")
 */
class Client
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     *
     * @ORM\Column(name="birth_date", type="date", nullable=false)
     */
    private $birthDate = null;

    /**
     * @ORM\ManyToOne(targetEntity="LG\CoreBundle\Entity\Booking", inversedBy="clients")
     */
    private $booking;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Client
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Client
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Client
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set birthDate
     *
     * @param Date $birthDate
     *
     * @return Client
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = new \DateTime($birthDate);

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return Date
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set booking
     *
     * @param Booking $booking
     *
     * @return Client
     */
    public function setBooking(Booking $booking = null)
    {
        $this->booking = $booking;

        return $this;
    }

    /**
     * Get booking
     *
     * @return Booking
     */
    public function getBooking()
    {
        return $this->booking;
    }
}
