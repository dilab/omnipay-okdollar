<?php

namespace Omnipay\OkDollar\Message;

class CompletePurchaseRequest extends \Omnipay\Common\Message\AbstractRequest
{
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

    public function sendData($data)
    {
        return new CompletePurchaseResponse($this, $data);
    }

    public function getData()
    {
        $data = $this->httpRequest->request->all();
        $data['isCredentialMatch'] = $this->isCredentialMatch($data);
        return $data;
    }

    private function isCredentialMatch($data)
    {
        return isset($data['Destination']) && $data['Destination'] == $this->getMerchantNumber();
    }


}
