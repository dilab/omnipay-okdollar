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
            'merchantNumber' => ('00959891006322'),
            'merchantName' => ('CGM'),
            'apiKey' => '1234566789',
            'encryptionKey' => 'BFC5B34FD9803540',
            'amount' => (4.06),
            'currency' => ('MMK'),
            'transactionId' => ('sp-20201231-889743')
        ]);

        $response = [
            'PayMentDet' => 'IIPcDkWKqj+30cUeflF+/TVEsAXwxx1Zoe8n81Yjni+WaFsgdBBoBsfFkPs+iNyCAIBVxjBaQhMEq+F6npdWl/Dip'.
                'DTIbW7hsiLy3bHdzfYhzOId12jNXcd6K7O9wnSm1nZnR6lzNzzCbIGHcyKS/NRpYPn/ssRK8ZaYveg9RAvVHq4DB5QbsduHPqS+YX3'.
                'RA0NjED/eaXTh/H6gWpk9ur8/hEAJa23BVg9UM/CGojPLhOv59zWIEhMpEbn0qB5Z6XxmWyenB0K3oC1ctZwxWTSSBeQmSakeE/sWR'.
                '9JtTpIv1ruPpbgbi1BKW4TXZU1qXU3Ooghhb4SWB+oeqrK3GqUvGrgIAVNX1qJXEdKMC/IKzEr3WIDlip6q0BHQCY0qivnuHWb07V5'.
                'EEEn+k/gc5ioDiTxdamo2lwb0wkCtbLgBcyK8B0UiGB3ZyD3cuYXjHTBuw4YtJXJoll1hlNpF3/dEApqO1wFdJAOMIBqe5B/932rKk8'.
                '8UEcv0Nr5X8Xd8I0n28v2R0BgW/PtMyY0vHrmhtmPDN4cv6kp+IE2q2vKkjluj2g2bwkLiSRqoZHG/zM7Zhmsh+ZMkWHS0qO1GEg=='.
                ',aaa70107bf3d030d,00959891006322'
        ];

        $this->getHttpRequest()->request->replace($response);

        $this->assertEquals('00959891006322', $this->request->getData()['Destination']);
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

}
