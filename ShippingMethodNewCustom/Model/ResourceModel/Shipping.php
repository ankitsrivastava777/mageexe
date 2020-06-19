<?php
/**
 * Copyright © 2015 Excellence. All rights reserved.
 */
namespace Excellence\ShippingMethodNewCustom\Model\ResourceModel;

/**
 * Shipping resource
 */
class Shipping extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('shippingmethodnewcustom_shipping', 'id');
    }

  
}
