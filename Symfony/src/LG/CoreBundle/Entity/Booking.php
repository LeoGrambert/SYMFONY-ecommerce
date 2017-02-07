<?php

namespace LG\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     * @Assert\Date()
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
     * @var string
     * 
     * @ORM\Column(name="email", type="string")
     * @Assert\Email(
     *     message="L'adresse email indiquée n'est pas valide. Veuillez rentrer une adresse correcte, vous y recevrez vos billets d'entrée.",
     *     checkMX = true
     *     )
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="ticket_number_normal", type="integer")
     * @Assert\Range(
     *     min=0,
     *     max=100,
     *     minMessage="Vous ne pouvez pas sélectionner un nombre négatif",
     *     maxMessage="Si vous souhaitez commander plus de 100 billets, contactez le Musée."
     * )
     */
    private $ticketNumberNormal = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="ticket_number_reduce", type="integer")
     * @Assert\Range(
     *     min=0,
     *     max=100,
     *     minMessage="Vous ne pouvez pas sélectionner un nombre négatif",
     *     maxMessage="Si vous souhaitez commander plus de 100 billets, contactez le Musée."
     * )
     */
    private $ticketNumberReduce = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="ticket_number_child", type="integer")
     * @Assert\Range(
     *     min=0,
     *     max=100,
     *     minMessage="Vous ne pouvez pas sélectionner un nombre négatif",
     *     maxMessage="Si vous souhaitez commander plus de 100 billets, contactez le Musée."
     * )
     */
    private $ticketNumberchild = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="ticket_number_senior", type="integer")
     * @Assert\Range(
     *     min=0,
     *     max=100,
     *     minMessage="Vous ne pouvez pas sélectionner un nombre négatif",
     *     maxMessage="Si vous souhaitez commander plus de 100 billets, contactez le Musée."
     * )
     */
    private $ticketNumberSenior = 0;

    /**
     * @ORM\OneToOne(targetEntity="LG\CoreBundle\Entity\Payment")
     */
    private $payment;

    /**
     * @ORM\OneToMany(targetEntity="LG\CoreBundle\Entity\Client", mappedBy="booking", cascade={"persist"})
     */
    private $clients;

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
     * Set ticketNumberchild
     *
     * @param integer $ticketNumberchild
     *
     * @return Booking
     */
    public function setTicketNumberchild($ticketNumberchild)
    {
        $this->ticketNumberchild = $ticketNumberchild;

        return $this;
    }

    /**
     * Get ticketNumberchild
     *
     * @return integer
     */
    public function getTicketNumberchild()
    {
        return $this->ticketNumberchild;
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
}
