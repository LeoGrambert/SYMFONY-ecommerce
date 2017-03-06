<?php

namespace LG\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Booking entity
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="LG\CoreBundle\Repository\BookingRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\EntityListeners({"LG\CoreBundle\Entity\EntityListener\BookingTokenListener"})
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
     * @Assert\NotNull(
     *     message="Veuillez choisir une date de réservation.",
     * )
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
     * @var string
     *
     * @ORM\Column(name="code_reservation", type="string")
     */
    private $codeReservation;

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
     * @var string
     * @ORM\Column(name="token", type="string", nullable=true)
     */
    private $token;

    /**
     * @var int
     *
     * @ORM\Column(name="ticket_number_normal", type="integer")
     * @Assert\Range(
     *     min=0,
     *     max=20,
     *     minMessage="Vous ne pouvez pas sélectionner un nombre négatif",
     *     maxMessage="Vous ne pouvez pas commander plus de 20 billets pour le tarif normal. Contactez le Musée pour organiser une visite de groupe."
     * )
     */
    private $ticketNumberNormal = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="ticket_number_reduce", type="integer")
     * @Assert\Range(
     *     min=0,
     *     max=20,
     *     minMessage="Vous ne pouvez pas sélectionner un nombre négatif",
     *     maxMessage="Vous ne pouvez pas commander plus de 20 billets pour le tarif réduit. Contactez le Musée pour organiser une visite de groupe."
     * )
     */
    private $ticketNumberReduce = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="ticket_number_child", type="integer")
     * @Assert\Range(
     *     min=0,
     *     max=20,
     *     minMessage="Vous ne pouvez pas sélectionner un nombre négatif",
     *     maxMessage="Vous ne pouvez pas commander plus de 20 billets pour le tarif enfant. Contactez le Musée pour organiser une visite de groupe."
     * )
     */
    private $ticketNumberChild = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="ticket_number_senior", type="integer")
     * @Assert\Range(
     *     min=0,
     *     max=20,
     *     minMessage="Vous ne pouvez pas sélectionner un nombre négatif",
     *     maxMessage="Vous ne pouvez pas commander plus de 20 billets pour le tarif senior. Contactez le Musée pour organiser une visite de groupe."
     * )
     */
    private $ticketNumberSenior = 0;

    /**
     * @var int
     * @ORM\Column(name="state_order", type="integer")
     */
    private $stateOrder;

    /**
     * @ORM\OneToMany(targetEntity="LG\CoreBundle\Entity\Client", mappedBy="booking", cascade={"persist"})
     */
    private $clients;

    /**
     * Booking constructor.
     */
    public function __construct()
    {
        $this->dateAchat = new \DateTime();
        $this->codeReservation = $this->generateCodeReservation();
        $this->stateOrder = 1;
    }

    /**
     * @return string
     * This function generate a random string with numbers and letters
     */
    public function random($size)
    {
        $string = "";
        $chainLetter = "AZERTYUIOPQSDFGHJKLMWXCVBN";
        $chainNumber = "123456789";
        srand((double)microtime() * 1000000);
        for ($i = 0; $i < $size; $i++) {
            $string .= $chainLetter[rand() % strlen($chainLetter)] . $chainNumber[rand() % strlen($chainNumber)];
        }
        return $string;
    }

    /**
     * @return string
     * This function generate a unique code reservation using random method and dateAchat attribute.
     * Return is called in constructor method.
     */
    public function generateCodeReservation(){
        $dateAchat = $this->getDateAchat()->format('YmdHis');
        $codeReservation = $this->random(3).$dateAchat;
        return $codeReservation;
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
     * Set codeReservation
     *
     * @param string $codeReservation
     *
     * @return Booking
     */
    public function setCodeReservation($codeReservation)
    {
        $this->codeReservation = $codeReservation;

        return $this;
    }

    /**
     * Get codeReservation
     *
     * @return string
     */
    public function getCodeReservation()
    {
        return $this->codeReservation;
    }

    /**
     * @param $idBooking
     * @return mixed
     */
    private function generateToken($idBooking) {
        $now = new \DateTime();
        return $this->token = md5($now->getTimestamp() + $idBooking);
    }

    /**
     * @param $idBooking
     */
    public function setToken($idBooking)
    {
        $this->token = $this->generateToken($idBooking);
    }

    /**
     * @return string
     */
    public function getToken(){
        return $this->token;
    }

    /**
     * @return int
     */
    public function getStateOrder(){
        return $this->stateOrder;
    }

    /**
     * @param $stateOrder
     * @return mixed
     */
    public function setStateOrder($stateOrder){
        $this->stateOrder = $stateOrder;
        return $stateOrder;
    }
}
