<?php
namespace Excellence\Checkout\Plugin\Checkout\Helper;

class Cart
{
    public function afterGetDeletePostJson($subject, $result)
    {
        $result = json_decode($result, true);
        $result['data']['confirmation'] = true;
        $result['data']['confirmationMessage'] = 'Would you like to remove this product?';
        return json_encode($result);
    }
}