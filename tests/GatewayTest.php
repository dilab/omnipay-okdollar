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
            'encryptionKey' => $encryptionKey = ('BFC5B34FD9803540'),
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
            'PayMentDet' => 'IIPcDkWKqj+30cUeflF+/TVEsAXwxx1Zoe8n81Yjni+WaFsgdBBoBsfFkPs+iNyCAIBVxjBaQhMEq+F6npdWl/Dip'.
                'DTIbW7hsiLy3bHdzfYhzOId12jNXcd6K7O9wnSm1nZnR6lzNzzCbIGHcyKS/NRpYPn/ssRK8ZaYveg9RAvVHq4DB5QbsduHPqS+YX3'.
                'RA0NjED/eaXTh/H6gWpk9ur8/hEAJa23BVg9UM/CGojPLhOv59zWIEhMpEbn0qB5Z6XxmWyenB0K3oC1ctZwxWTSSBeQmSakeE/sWR'.
                '9JtTpIv1ruPpbgbi1BKW4TXZU1qXU3Ooghhb4SWB+oeqrK3GqUvGrgIAVNX1qJXEdKMC/IKzEr3WIDlip6q0BHQCY0qivnuHWb07V5'.
                'EEEn+k/gc5ioDiTxdamo2lwb0wkCtbLgBcyK8B0UiGB3ZyD3cuYXjHTBuw4YtJXJoll1hlNpF3/dEApqO1wFdJAOMIBqe5B/932rKk8'.
                '8UEcv0Nr5X8Xd8I0n28v2R0BgW/PtMyY0vHrmhtmPDN4cv6kp+IE2q2vKkjluj2g2bwkLiSRqoZHG/zM7Zhmsh+ZMkWHS0qO1GEg=='.
                ',aaa70107bf3d030d,00959891006322'
        ]);

        $response = $this->gateway->completePurchase($this->options)->send();

        $this->assertFalse($response->isSuccessful());
    }
}
