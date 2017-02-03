<?php

namespace LG\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="LG\CoreBundle\Repository\BookingRepository")
 */
class Booking
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
     * @var \DateTime
     * @ORM\Column(name="date_reservation", type="date")
     */
    private $dateReservation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_achat", type="datetime")
     */
    private $dateAchat;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_daily", type="boolean")
     */
    private $isDaily;

    /**
     * @var int
     *
     * @ORM\Column(name="ticket_number_normal", type="integer")
     */
    private $ticketNumberNormal = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="ticket_number_child", type="integer")
     */
    private $ticketNumberChild = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="ticket_number_senior", type="integer")
     */
    private $ticketNumberSenior = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="ticket_number_reduce", type="integer")
     */
    private $ticketNumberReduce = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity="LG\CoreBundle\Entity\Payment")
     */
    private $payment;

    /**
     * @ORM\OneToMany(targetEntity="LG\CoreBundle\Entity\Client", mappedBy="booking", cascade={"persist"})
     */
    private $clients;

    /**
     * @var bool
     *
     * @ORM\Column(name="cgv_accept", type="boolean")
     */
    private $cgvAccept;

    public function __construct()
    {
        $this->dateAchat = new \DateTime();
        $this->dateReservation = new \DateTime();
//        $this->clients = new ArrayCollection();
    }
    

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
     * Set dateReservation
     *
     * @param \DateTime $dateReservation
     *
     * @return Booking
     */
    public function setDateReservation($dateReservation)
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    /**
     * Get dateReservation
     *
     * @return \DateTime
     */
    public function getDateReservation()
    {
        return $this->dateReservation;
    }

    /**
     * Set dateAchat
     *
     * @param \DateTime $dateAchat
     *
     * @return Booking
     */
    public function setDateAchat($dateAchat)
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    /**
     * Get dateAchat
     *
     * @return \DateTime
     */
    public function getDateAchat()
    {
        return $this->dateAchat;
    }

    /**
     * Set isDaily
     *
     * @param boolean $isDaily
     *
     * @return Booking
     */
    public function setIsDaily($isDaily)
    {
        $this->isDaily = $isDaily;

        return $this;
    }

    /**
     * Get isDaily
     *
     * @return boolean
     */
    public function getIsDaily()
    {
        return $this->isDaily;
    }

    /**
     * Set ticketNumberNormal
     *
     * @param integer $ticketNumberNormal
     *
     * @return Booking
     */
    public function setTicketNumberNormal($ticketNumberNormal)
    {
        $this->ticketNumberNormal = $ticketNumberNormal;

        return $this;
    }

    /**
     * Get ticketNumberNormal
     *
     * @return integer
     */
    public function getTicketNumberNormal()
    {
        return $this->ticketNumberNormal;
    }

    /**
     * Set ticketNumberChild
     *
     * @param integer $ticketNumberChild
     *
     * @return Booking
     */
    public function setTicketNumberChild($ticketNumberChild)
    {
        $this->ticketNumberChild = $ticketNumberChild;

        return $this;
    }

    /**
     * Get ticketNumberChild
     *
     * @return integer
     */
    public function getTicketNumberChild()
    {
        return $this->ticketNumberChild;
    }

    /**
     * Set ticketNumberSenior
     *
     * @param integer $ticketNumberSenior
     *
     * @return Booking
     */
    public function setTicketNumberSenior($ticketNumberSenior)
    {
        $this->ticketNumberSenior = $ticketNumberSenior;

        return $this;
    }

    /**
     * Get ticketNumberSenior
     *
     * @return integer
     */
    public function getTicketNumberSenior()
    {
        return $this->ticketNumberSenior;
    }

    /**
     * Set ticketNumberReduce
     *
     * @param integer $ticketNumberReduce
     *
     * @return Booking
     */
    public function setTicketNumberReduce($ticketNumberReduce)
    {
        $this->ticketNumberReduce = $ticketNumberReduce;

        return $this;
    }

    /**
     * Get ticketNumberReduce
     *
     * @return integer
     */
    public function getTicketNumberReduce()
    {
        return $this->ticketNumberReduce;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Booking
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set cgvAccept
     *
     * @param boolean $cgvAccept
     *
     * @return Booking
     */
    public function setCgvAccept($cgvAccept)
    {
        $this->cgvAccept = $cgvAccept;

        return $this;
    }

    /**
     * Get cgvAccept
     *
     * @return boolean
     */
    public function getCgvAccept()
    {
        return $this->cgvAccept;
    }

    /**
     * Set payment
     *
     * @param \LG\CoreBundle\Entity\Payment $payment
     *
     * @return Booking
     */
    public function setPayment(\LG\CoreBundle\Entity\Payment $payment = null)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return \LG\CoreBundle\Entity\Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Add client
     *
     * @param \LG\CoreBundle\Entity\Client $client
     *
     * @return Booking
     */
    public function addClient(\LG\CoreBundle\Entity\Client $client)
    {
        $this->clients[] = $client;

        return $this;
    }

    /**
     * Remove client
     *
     * @param \LG\CoreBundle\Entity\Client $client
     */
    public function removeClient(\LG\CoreBundle\Entity\Client $client)
    {
        $this->clients->removeElement($client);
    }

    /**
     * Get clients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClients()
    {
        return $this->clients;
    }
}
