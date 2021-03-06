<?php

namespace Omnipay\OkDollar;


use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'OkDollar';
    }

    public function getDefaultParameters()
    {
        return [
            'merchantNumber' => '',
            'merchantName' => '',
            'apiKey' => '',
            'encryptionKey' => '',
            'postUrl' => '',
        ];
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
        return $this->getParameter('MerchantNumber');
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

    public function purchase(array $options = [])
    {
        return $this->createRequest('\Omnipay\OkDollar\Message\PurchaseRequest', $options);
    }

    public function completePurchase(array $options = [])
    {
        return $this->createRequest('\Omnipay\OkDollar\Message\CompletePurchaseRequest', $options);
    }


}
