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
    public function testClientFirstName(){
        $client = new Client();
        $client->setFirstName('Test');
        $this->assertNotNull($client->getFirstName());
    }
    
    public function testClientCountry(){
        $client = new Client();
        $client->setCountry('France');
        $this->assertNotNull($client->getCountry());
    }
}