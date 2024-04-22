<?php

declare(strict_types=1);

namespace Magepro\Test\Block;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Helper\Output as OutputHelper;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Catalog\Ui\DataProvider\Product\ProductCollectionFactory;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Url\Helper\Data;

class Featuredproduct extends ListProduct
{
    /**
     * @var ProductCollectionFactory $productCollectionFactory
     */
    private ProductCollectionFactory $productCollectionFactory;

    /**
     * @var Image $imageHelper
     */
    private Image $imageHelper;

    /**
     * @param Context $context
     * @param PostHelper $postDataHelper
     * @param Resolver $layerResolver
     * @param CategoryRepositoryInterface $categoryRepository
     * @param Data $urlHelper
     * @param ProductCollectionFactory $productCollectionFactory
     * @param Image $imageHelper
     * @param array $data
     * @param OutputHelper|null $outputHelper
     */
    public function __construct(
        Context                     $context,
        PostHelper                  $postDataHelper,
        Resolver                    $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        Data                        $urlHelper,
        ProductCollectionFactory    $productCollectionFactory,
        Image                       $imageHelper,
        array                       $data = [],
        ?OutputHelper               $outputHelper = null
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->imageHelper = $imageHelper;
        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data, $outputHelper);
    }

    /**
     * @return array
     */
    public function getProductList(): array
    {
        $productList = [];

        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*')
            ->addAttributeToFilter('featured', 1)
            ->setPageSize(4);

        $products = $collection->getItems();

        foreach ($products as $key => $product) {
            $productList[$key]['id'] = $product->getData('entity_id');
            $productList[$key]['sku'] = $product->getData('sku');
            $productList[$key]['image'] = $this->imageHelper->init($product, 'product_base_image')->getUrl();
            $productList[$key]['name'] = $product->getData('name');
            $productList[$key]['description'] = $product->getData('short_description');
            $productList[$key]['url'] = $this->getProductUrl($product);
            $productList[$key]['price'] = $this->getProductPrice($product);
            $productList[$key]['postParams'] = $this->getAddToCartPostParams($product);
        }

        return $productList;
    }
}
