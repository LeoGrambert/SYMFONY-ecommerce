<?php

namespace LG\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="date")
     */
    private $birthDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="prices", type="string")
     */
    private $prices;

    /**
     * @ORM\ManyToOne(targetEntity="LG\CoreBundle\Entity\Booking", inversedBy="clients")
     */
    private $booking;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return boolean
     */
    public function isPrices()
    {
        return $this->prices;
    }

    /**
     * @param boolean $prices
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;
    }
    

    /**
     * Get prices
     *
     * @return boolean
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * Set booking
     *
     * @param \LG\CoreBundle\Entity\Booking $booking
     *
     * @return Client
     */
    public function setBooking(\LG\CoreBundle\Entity\Booking $booking)
    {
        $this->booking = $booking;

        return $this;
    }

    /**
     * Get booking
     *
     * @return \LG\CoreBundle\Entity\Booking
     */
    public function getBooking()
    {
        return $this->booking;
    }
}
