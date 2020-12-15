<?php

namespace Message;

use Omnipay\OkDollar\Message\CompletePurchaseResponse;
use Omnipay\Tests\TestCase;

class CompletePurchaseResponseTest extends TestCase
{
    /**
     * @var CompletePurchaseResponse
     */
    public $response;

    protected function setUp()
    {
        parent::setUp();
    }

    public function successResponse()
    {
        return [
            'isCredentialMatch' => true,
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
    }

    public function failedResponse()
    {
        return [
            'isCredentialMatch' => false,
            'ResponseCode' => '300',
            'Destination' => 'your Merchant account number ',
            'Source' => 'Customer account number ',
            'Amount' => '500',
            'TransactionId' => '',
            'TransactionTime' => '',
            'AgentName' => '',
            'Kickvalue' => '',
            'Loyaltypoints' => '',
            'Description' => 'Root element is missing.',
            'InitiateOKAccNumber' => null,
        ];
    }

    public function test_it_checks_success()
    {
        $request = $this->getMockRequest();

        $data = $this->successResponse();

        $this->response = new CompletePurchaseResponse($request, $data);

        $this->assertTrue($this->response->isSuccessful());
        $this->assertFalse($this->response->isPending());
        $this->assertFalse($this->response->isRedirect());
        $this->assertFalse($this->response->isTransparentRedirect());
        $this->assertFalse($this->response->isCancelled());
        $this->assertEquals('CGMEComAx20161331931653', $this->response->getTransactionId());
        $this->assertEquals('62795067', $this->response->getTransactionReference());
    }

    public function test_it_checks_failure()
    {
        $request = $this->getMockRequest();

        $data = $this->failedResponse();
        $this->response = new CompletePurchaseResponse($request, $data);
        $this->assertFalse($this->response->isSuccessful());

        $data = $this->successResponse();
        $data['isCredentialMatch'] = false;
        $this->response = new CompletePurchaseResponse($request, $data);
        $this->assertFalse($this->response->isSuccessful());
    }
}
