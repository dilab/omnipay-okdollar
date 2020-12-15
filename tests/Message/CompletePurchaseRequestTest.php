<?php

namespace Message;

use Omnipay\OkDollar\Message\CompletePurchaseRequest;
use Omnipay\OkDollar\Message\CompletePurchaseResponse;
use Omnipay\Tests\TestCase;


class CompletePurchaseRequestTest extends TestCase
{

    /**
     * @var CompletePurchaseRequest
     */
    public $request;

    protected function setUp()
    {
        parent::setUp();
        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function test_it_can_get_data()
    {
        $this->request->initialize([
            'card' => [
                'phone' => ('00959787190850'),
            ],
            'merchantNumber' => ('00959971813997'),
            'merchantName' => ('CGM'),
            'apiKey' => $key = ('1234566789'),
            'amount' => (4.06),
            'currency' => ('MMK'),
            'transactionId' => ('CGMEComAx20161331924438')
        ]);

        $response = [
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
        ];

        $this->getHttpRequest()->request->replace($response);

        $this->assertArraySubset($response, $this->request->getData());
    }

    public function test_it_can_send_data()
    {
        $this->request->initialize([
            'card' => [
                'phone' => ('00959787190850'),
            ],
            'merchantNumber' => ('00959971813997'),
            'merchantName' => ('CGM'),
            'apiKey' => $key = ('1234566789'),
            'amount' => (4.06),
            'currency' => ('MMK'),
            'transactionId' => ('CGMEComAx20161331924438')
        ]);

        $this->assertInstanceOf(CompletePurchaseResponse::class, $this->request->sendData([]));
    }

    public function test_it_can_check_credential()
    {
        $this->request->initialize([
            'card' => [
                'phone' => ('00959787190850'),
            ],
            'merchantNumber' => ('00959971813997'),
            'merchantName' => ('CGM'),
            'apiKey' => $key = ('1234566789'),
            'amount' => (4.06),
            'currency' => ('MMK'),
            'transactionId' => ('CGMEComAx20161331924438')
        ]);

        $response = [
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
        ];

        $this->getHttpRequest()->request->replace($response);
        $this->assertTrue($this->request->getData()['isCredentialMatch']);


        $response['Destination'] = '1234567';
        $this->getHttpRequest()->request->replace($response);
        $this->assertFalse($this->request->getData()['isCredentialMatch']);
    }
}
