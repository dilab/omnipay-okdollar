<?php

namespace Omnipay\OkDollar\Message;


use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
{
    /**
     * @var PurchaseResponse
     */
    public $response;

    protected function setUp()
    {
        parent::setUp();

        $this->response = new PurchaseResponse(
            new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest()),
            [
                'requestToJson' => [
                    'RefNumber' => 'transaction_id'
                ]
            ]
        );
    }

    public function test_its_redirects()
    {
        $this->assertFalse($this->response->isSuccessful());
        $this->assertTrue($this->response->isRedirect());
        $this->assertTrue($this->response->isPending());
        $this->assertTrue($this->response->isTransparentRedirect());
    }


}
