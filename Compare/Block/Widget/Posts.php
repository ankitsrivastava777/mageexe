<?php

namespace Excellence\Compare\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;


class Posts extends Template implements BlockInterface
{
    public $_template = "widget/posts.phtml";
    protected $_productRepositoryFactory;
    protected $_storeManager;
    protected $productFactory;

    protected $compareProducts;
    public function __construct(
        \Magento\Catalog\CustomerData\CompareProducts $compareProducts,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\Product\Compare\ListCompare $listCompare,
        \Magento\Catalog\Api\ProductRepositoryInterfaceFactory $productRepositoryFactory,
        \Magento\Store\Model\StoreManagerInterface $storemanager,
        \Magento\Catalog\Model\ProductFactory $productFactory,

        array $data = []

    ) {
        $this->compareProducts = $compareProducts;
        parent::__construct($context, $data);
        $this->listCompare = $listCompare;
        $this->_productRepositoryFactory = $productRepositoryFactory;
        $this->_storeManager =  $storemanager;
        $this->productFactory = $productFactory;
    }

    /*
    * Get current compare product list
    */
    public function getCompareList()
    {
        return $this->compareProducts->getSectionData();
        // print_r($this->compareProducts->getSectionData());
    }

    public function getCompareList1($productId)
    {
        $store = $this->_storeManager->getStore();
        $product = $this->_productRepositoryFactory->create()->getById($productId);
        $productImageUrl = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $product->getData('thumbnail');
        $productUrl = $product->getProductUrl();
        return $productImageUrl;
    }
    public function getCompareList2($productId)
    {
        // return  $this->listCompare->getItemCollection();
        // echo "<pre>";
        $compareObject = $this->compareProducts->getSectionData();
        // foreach ($compareObject['items'] as $comparelist) {
            // $proId = $comparelist['id'];
            $product = $this->productFactory->create();
            $productPriceById = $product->load($productId)->getPrice();
           return number_format($productPriceById, 2, '.', '');
        // }
    }
}
