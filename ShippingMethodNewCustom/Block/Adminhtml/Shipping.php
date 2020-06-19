<?php
namespace Excellence\ShippingMethodNewCustom\Block\Adminhtml;
class Shipping extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_shipping';/*block grid.php directory*/
        $this->_blockGroup = 'Excellence_ShippingMethodNewCustom';
        $this->_headerText = __('Shipping');
        $this->_addButtonLabel = __('Add New Entry'); 
        parent::_construct();
		
    }
}
