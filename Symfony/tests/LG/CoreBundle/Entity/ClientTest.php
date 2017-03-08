<?php
/**
 * User: leo
 * Date: 07/03/17
 * Time: 18:44
 */

namespace tests\LG\CoreBundle\Entity;

use LG\CoreBundle\Entity\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * Test first name attribute from Client entity
     */
    public function testClientFirstName(){
        $client = new Client();
        $client->setFirstName('Test');
        $this->assertNotNull($client->getFirstName());
    }

    /**
     * Test country attribute form Client entity
     */
    public function testClientCountry(){
        $client = new Client();
        $client->setCountry('France');
        $this->assertNotNull($client->getCountry());
    }
}