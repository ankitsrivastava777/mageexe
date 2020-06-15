<?php
namespace Excellence\CustomOption\Block;

class CustomOption extends \Magento\Framework\View\Element\Template
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Model\Product\Option $optionFactory,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        $this->optionFactory = $optionFactory;
        parent::__construct($context,$data);
    }

    /**
    * @param string $sku
    */
    public function addCustomOption()
    {
        try {
            $_product = $this->productRepository->get("sample-01");
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Such product doesn\'t exist'));
        }
        $optionsArray = [
            [
                'title' => 'Select option',
                'type' => 'drop_down',
                'is_require' => 1,
                'sort_order' => 1,
                'values' => [
                    [
                        'title' => 'Option 1',
                        'price' => 10,
                        'price_type' => 'fixed',
                        'sku' => 'Option 1 sku',
                        'sort_order' => 1,
                    ],
                    [
                        'title' => 'Option 2',
                        'price' => 10,
                        'price_type' => 'fixed',
                        'sku' => 'Option 2 sku',
                        'sort_order' => 2,
                    ],
                    [
                        'title' => 'Option 3',
                        'price' => 10,
                        'price_type' => 'fixed',
                        'sku' => 'Option 3 sku',
                        'sort_order' => 3,
                    ],
                ],
            ]
        ];

        foreach ($optionsArray as $optionValue) {
            $option = $this->optionFactory
                        ->setProductId($_product->getId())
                        ->setStoreId($_product->getStoreId())
                        ->addData($optionValue);
            $option->save();
            $_product->addOption($option);
            // must save product to add options in product
            $this->productRepository->save($_product);
        }
    }

}