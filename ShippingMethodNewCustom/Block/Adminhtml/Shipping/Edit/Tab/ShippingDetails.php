<?php

namespace Excellence\ShippingMethodNewCustom\Block\Adminhtml\Shipping\Edit\Tab;

class ShippingDetails extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
    protected $_countryFactory;


    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Directory\Model\Config\Source\Country $countryFactory,

        array $data = array()
    ) {
        $this->_systemStore = $systemStore;
        $this->_countryFactory = $countryFactory;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /* @var $model \Magento\Cms\Model\Page */
        $model = $this->_coreRegistry->registry('shippingmethodnewcustom_shipping');
        $isElementDisabled = false;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => __('Shipping Details')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }

        $fieldset->addField(
            'shipping price',
            'text',
            array(
                'name' => 'shippingprice',
                'label' => __('Shipping Price'),
                'title' => __('shipping price'),
                /*'required' => true,*/
            )
        );
        $optionsc = $this->_countryFactory->toOptionArray();
        $country = $fieldset->addField(
            'country',
            'select',
            array(
                'name' => 'country',
                'label' => __('Country'),
                'title' => __('country'),
                /*'required' => true,*/
                'values' => $optionsc,
            )
        );
        $fieldset->addField(
            'zipcode',
            'textarea',
            array(
                'name' => 'zipcode',
                'label' => __('Zip Code'),
                'title' => __('zip code'),
                /*'required' => true,*/
            )
        );
        $fieldset->addField(
            'max allowed weight',
            'text',
            array(
                'name' => 'maxallowedweight',
                'label' => __('Max Allowed Weight'),
                'title' => __('max allowed weight'),
                /*'required' => true,*/
            )
        );
        /*{{CedAddFormField}}*/

        if (!$model->getId()) {
            $model->setData('status', $isElementDisabled ? '2' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Shipping Details');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Shipping Details');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
