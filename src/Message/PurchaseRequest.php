<?php

namespace Omnipay\OkDollar\Message;


class PurchaseRequest extends \Omnipay\Common\Message\AbstractRequest
{
    private $iv;

    public function sendData($data)
    {
        return new PurchaseResponse($this, $data);
    }

    public function getPostUrl()
    {
        return $this->getParameter('postUrl');
    }

    public function setPostUrl($postUrl)
    {
        return $this->setParameter('postUrl', $postUrl);
    }

    public function getMerchantNumber()
    {
        return $this->getParameter('merchantNumber');
    }

    public function setMerchantNumber($merchantNumber)
    {
        return $this->setParameter('merchantNumber', $merchantNumber);
    }

    public function getMerchantName()
    {
        return $this->getParameter('merchantName');
    }

    public function setMerchantName($merchantName)
    {
        return $this->setParameter('merchantName', $merchantName);
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($apiKey)
    {
        return $this->setParameter('apiKey', $apiKey);
    }

    public function getEncryptionKey()
    {
        return $this->getParameter('encryptionKey');
    }

    public function setEncryptionKey($encryptionKey)
    {
        return $this->setParameter('encryptionKey', $encryptionKey);
    }

    public function getIv()
    {
        return $this->iv;
    }

    public function getData()
    {
        return [
            'requestToJson' => $this->encryptedText($this->getDataPlain())
                . ',' . $this->getIv()
                . ',' . $this->getMerchantNumber()
        ];
    }

    public function getDataPlain()
    {
        $amount = number_format($this->getAmount(), 2, '.', '');

        return [
            'Destination' => $this->getMerchantNumber(),
            'Amount' => floatval($amount),
            'Source' => $this->getCard()->getPhone(),
            'ApiKey' => $this->getApiKey(),
            'MerchantName' => $this->getMerchantName(),
            'RefNumber' => $this->getTransactionId(),
        ];
    }

    private function encryptedText(array $getDataPlain)
    {
        $plainText = json_encode($getDataPlain);
        $cipher = 'aes-128-cbc';
        $ivByte = openssl_random_pseudo_bytes(8);
        $iv = bin2hex($ivByte);
        $this->iv = $iv;
        return openssl_encrypt($plainText, $cipher, $this->getEncryptionKey(), $options = 0, $iv);
    }

}
