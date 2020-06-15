<?php declare(strict_types=1);


namespace Excellence\Compare2\Controller\Index;


class Compare extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $jsonHelper;
protected $_productRepositoryFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Catalog\Helper\Image $imageHelper,
\Magento\Catalog\Api\ProductRepositoryInterfaceFactory $productRepositoryFactory,
              \Magento\Framework\Json\Helper\Data $jsonHelper,
                      \Magento\Framework\App\Request\Http $request


    )

     {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
           $this->imageHelper = $imageHelper;
    $this->_productRepositoryFactory = $productRepositoryFactory;
            $this->jsonHelper = $jsonHelper;
                   $this->request = $request;


    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        
        // $post = $this->getRequest()->getPostValue
           $productId =  $this->request->getParams(); // all params

         //        $_product = $this->productRepository->getById($productId);
         // $image_url = $this->imageHelper->init($_product, 'product_base_image')->getUrl();
        // return $image_url;
           $product = $this->_productRepositoryFactory->create()->getById(4);
$product->getData('image');
$product->getData('thumbnail');
$image_url = $product->getData('small_image');




        return $this->jsonResponse($image_url."hello");         
    }

      public function jsonResponse($response = '')
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($response)
        );
    }

}

