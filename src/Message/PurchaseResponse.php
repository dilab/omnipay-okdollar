<?php

namespace Omnipay\OkDollar\Message;

use Omnipay\Common\Message\AbstractResponse;

class PurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return false;
    }

    public function isPending()
    {
        return true;
    }

    public function isTransparentRedirect()
    {
        return true;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectData()
    {
        return $this->getData();
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }


}
