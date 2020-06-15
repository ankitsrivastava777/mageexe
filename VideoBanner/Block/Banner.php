<?php

namespace Excellence\VideoBanner\Block;

class Banner extends \Magento\Framework\View\Element\Template
{
    protected $_values = null;
    protected $_scopeConfig;
    protected $helperData;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Excellence\VideoBanner\Helper\Data $helperData,

        array $data = []
    ) {
        parent::__construct($context, $data);
    }
    public function getBannerConfig()
    {
        return $this->helperData->getBannerConfig();
    }
}
