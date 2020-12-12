<?php


namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class UpdateFarmTest
 * @package App\Tests
 */
class UpdateFarmTest extends WebTestCase
{
   use AuthenticationTrait;

    /**
     *
     */
    public function testSuccessFarmUpdate(): void
    {
        $client = static::createAuthenticationClient('producer@email.com');
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('farm_update'));
        $form = $crawler->filter("form[name=farm]")->form([
            "farm[name]" => 'exploitation',
            "farm[description]" => 'description']);
        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}