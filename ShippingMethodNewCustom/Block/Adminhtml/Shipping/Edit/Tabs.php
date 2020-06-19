<?php
namespace Excellence\ShippingMethodNewCustom\Block\Adminhtml\Shipping\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
		
        parent::_construct();
        $this->setId('checkmodule_shipping_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Shipping Information'));
    }
}