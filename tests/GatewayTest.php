<?php

namespace Tests\OkDollar;


use Omnipay\OkDollar\Gateway;
use Omnipay\Tests\TestCase;

class GatewayTest extends TestCase
{
    /** @var Gateway */
    protected $gateway;

    /** @var array */
    private $options;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = [
            'card' => [
                'phone' => ('00959787190850'),
            ],
            'merchantNumber' => ('00959971813997'),
            'merchantName' => ('CGM'),
            'apiKey' => $key = ('1234566789'),
            'postUrl' => 'http://www.google.com',
            'amount' => (4.06),
            'currency' => ('MMK'),
            'transactionId' => ('CGMEComAx20161331924438'),
        ];
    }

    public function testPurchase()
    {
        $response = $this->gateway->purchase($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
    }

    public function testCompletePurchase()
    {
        $this->getHttpRequest()->request->replace([
            'ResponseCode' => '0',
            'Destination' => '00959971813997',
            'Source' => '00959787190850',
            'Amount' => '4.06',
            'TransactionId' => '62795067',
            'TransactionTime' => '13-Jul-2016 19:33:59',
            'AgentName' => 'MR,PERSONAL',
            'Kickvalue' => '',
            'Loyaltypoints' => '0',
            'Description' => 'Transaction Successful',
            'MerRefNo' => 'CGMEComAx20161331931653',
            'CustomerNumber' => '',
        ]);

        $response = $this->gateway->completePurchase($this->options)->send();

        $this->assertTrue($response->isSuccessful());

        $this->assertNotNull($response->getTransactionReference());
    }
}
