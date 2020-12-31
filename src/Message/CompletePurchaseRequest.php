<?php

namespace Omnipay\OkDollar\Message;

use RuntimeException;

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

    public function getEncryptionKey()
    {
        return $this->getParameter('encryptionKey');
    }

    public function setEncryptionKey($encryptionKey)
    {
        return $this->setParameter('encryptionKey', $encryptionKey);
    }

    public function sendData($data)
    {
        return new CompletePurchaseResponse($this, $data);
    }

    public function getData()
    {
        $data = $this->httpRequest->request->all();

        if (!isset($data['PayMentDet'])) {
            throw new RuntimeException('PayMentDet is not found in the callback');
        }

        return $this->decrypt($data['PayMentDet']);
    }

    private function decrypt($str)
    {
        $data = $this->getDataStr($str);
        $iv = $this->getIv($str);
        $cipher = 'aes-128-cbc';
        $decryptedJsonStr = openssl_decrypt($data, $cipher, $this->getEncryptionKey(), 0, $iv);
        return json_decode($decryptedJsonStr, true);
    }

    private function getDataStr($str)
    {
        $exploded = explode(',', $str);

        if (isset($exploded[0])) {
            return $exploded[0];
        }

        throw new RuntimeException(sprintf(
            'Data string is not found in %s', $str
        ));
    }

    private function getIv($str)
    {
        $exploded = explode(',', $str);

        if (isset($exploded[1])) {
            return $exploded[1];
        }

        throw new RuntimeException(sprintf(
            'Iv string is not found in %s', $str
        ));
    }

}
