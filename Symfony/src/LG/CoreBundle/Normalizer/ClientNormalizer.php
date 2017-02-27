<?php

namespace LG\CoreBundle\Normalizer;

use LG\CoreBundle\Entity\Client;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\scalar;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * Class ClientNormalizer
 * @package LG\CoreBundle\Normalizer
 */
class ClientNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    public function setSerializer(SerializerInterface $serializer)
    {
    }

    /**
     * @param Client $object
     * @param null $format
     * @param array $context
     * @return array
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return [
            "id" => $object->getId(),
            "lastName" => $object->getLastName(),
            "firstName" => $object->getFirstName(),
            "country" => $object->getCountry(),
            "birthDate" => $object->getBirthDate(),
        ];
    }

    /**
     * @param mixed $data
     * @param string $class
     * @param null $format
     * @param array $context
     * @return Client
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $client = new Client();
        $firstName = $data["firstName"];
        $client->setFirstName($firstName);
        $lastName = $data["lastName"];
        $client->setLastName($lastName);
        $country = $data["country"];
        $client->setCountry($country);
        $birthDate = $data["birthDate"];
        $client->setBirthDate($birthDate);
            
        return $client;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Client;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type == Client::class;
    }
}
