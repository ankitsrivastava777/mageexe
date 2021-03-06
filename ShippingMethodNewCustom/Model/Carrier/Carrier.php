<?php

namespace Excellence\ShippingMethodNewCustom\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;

class Carrier extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'carrier';
    protected $_ShippingFactory;
    protected $_cart;

    protected $_logger;
    /**
     * @var bool
     */
    protected $_isFixed = true;

    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    protected $_rateResultFactory;


    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    protected $_rateMethodFactory;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        \Excellence\ShippingMethodNewCustom\Model\ResourceModel\Shipping\CollectionFactory $shippingFactory,
        \Magento\Checkout\Model\Cart $cartModel,
        array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->_shippingFactory = $shippingFactory;
        $this->_logger = $logger;
        $this->_cart = $cartModel;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * @param RateRequest $request
     * @return \Magento\Shipping\Model\Rate\Result|bool
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }
        $grid = $this->_shippingFactory->create();
        $items = $this->_cart->getQuote()->getAllItems();
        $weight = 0;
        foreach ($items as $item) {
            $weight += ($item->getWeight() * $item->getQty());
        }

        $country = $request->getDestCountryId();
        $postalcode = $request->getDestPostcode();
        $grid = $this->_shippingFactory->create();
        $cont = $grid->addFieldToFilter('country', ['eq' => $country]);

        if ($cont->count() > 0) {
            $shippingPrice = 0;
            foreach ($cont as $contt) {
                $shippingPrice = $contt['shippingprice'];
            }
            $weighht = 0;
            foreach ($cont as $weigh) {
                $weighht = $weigh['maxallowedweight'];
            }
            $zip = 0;
            $zip2 = 0;
            foreach ($cont as $zipp) {
                $zip = $zipp['zipcode'];
                $zip2 = explode(",", $zipp['zipcode']);
            }
            if ($postalcode == $zip or $zip == '*' or in_array($postalcode, $zip2)) {
                if ($weight <= $weighht) {
                    /** @var \Magento\Shipping\Model\Rate\Result $result */
                    $result = $this->_rateResultFactory->create();
                    $method = $this->_rateMethodFactory->create();
                    $method->setCarrier($this->_code);
                    $method->setCarrierTitle($this->getConfigData('title'));
                    $method->setMethod($this->_code);
                    $method->setMethodTitle($this->getConfigData('name'));
                    $method->setPrice($shippingPrice);
                    $method->setCost($shippingPrice);
                    $result->append($method);

                    return $result;
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }
}
