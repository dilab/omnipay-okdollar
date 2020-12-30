<?php

namespace Omnipay\OkDollar\Message;


use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{

    /**
     * @var PurchaseRequest
     */
    public $request;

    protected function setUp()
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function test_it_can_get_plain_data()
    {
        $this->request->initialize([
            'card' => [
                'phone' => ('00959787190850'),
            ],
            'merchantNumber' => ('00959971813997'),
            'merchantName' => ('CGM'),
            'apiKey' => ('1234566789'),
            'amount' => (4.06),
            'currency' => ('MMK'),
            'transactionId' => ('CGMEComAx20161331924438')
        ]);

        $result = $this->request->getDataPlain();

        $expected = [
            'Destination' => '00959971813997',
            'Amount' => 4.06,
            'Source' => '00959787190850',
            'ApiKey' => '1234566789',
            'MerchantName' => 'CGM',
            'RefNumber' => 'CGMEComAx20161331924438',
        ];

        $this->assertEquals($expected, $result);
    }

    public function test_it_can_get_data()
    {
        $this->request->initialize([
            'card' => [
                'phone' => ('00959787190850'),
            ],
            'merchantNumber' => ('00959971813997'),
            'merchantName' => ('CGM'),
            'apiKey' =>  ('1234566789'),
            'encryptionKey' => $encryptionKey = ('1234566789'),
            'amount' => (4.06),
            'currency' => ('MMK'),
            'transactionId' => ('CGMEComAx20161331924438')
        ]);

        $result = $this->request->getData();

        $plainText = '{"Destination":"00959971813997","Amount":4.06,"Source":"00959787190850","ApiKey":"1234566789","MerchantName":"CGM","RefNumber":"CGMEComAx20161331924438"}';

        $cipher = 'aes-128-cbc';

        $requestToJson = $result['requestToJson'];

        $encryptedText = explode(',', $requestToJson)[0];

        $decrypted = openssl_decrypt($encryptedText, $cipher, $encryptionKey, 0, $this->request->getIv());

        $this->assertEquals($plainText, $decrypted);
    }

}
