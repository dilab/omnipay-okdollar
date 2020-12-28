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

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize([
            'card' => [
                'phone' => ('00959787190850'),
            ],
            'merchantNumber' => ('00959971813997'),
            'merchantName' => ('CGM'),
            'apiKey' => $key = ('1234566789'),
            'postUrl' => 'http://69.160.4.151:8082',
            'amount' => (4.06),
            'currency' => ('MMK'),
            'transactionId' => ('CGMEComAx20161331924438'),
        ]);

        $this->response = new PurchaseResponse(
            $this->request,
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
        $this->assertEquals('POST',$this->response->getRedirectMethod());
        $this->assertEquals('http://69.160.4.151:8082',$this->response->getRedirectUrl());
    }


}
