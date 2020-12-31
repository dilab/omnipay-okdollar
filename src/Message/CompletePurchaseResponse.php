<?php

namespace Omnipay\OkDollar\Message;

class CompletePurchaseResponse extends \Omnipay\Common\Message\AbstractResponse
{
    public function isSuccessful()
    {
        if (null == $this->data) {
            return false;
        }

        return $this->data['ResponseCode'] == 0 && $this->data['isCredentialMatch'];
    }

    public function getTransactionId()
    {
        return $this->data['MerRefNo'];
    }

    public function getTransactionReference()
    {
        return $this->data['TransactionId'];
    }

    public function getMessage()
    {
        return $this->data['Description'];
    }


}
