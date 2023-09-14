<?php

namespace MageGuide\SecondModule\Model\Resolver;

use Magento\Bundle\Plugin\Catalog\Helper\Product;
use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

use \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\GraphQl\Query\Resolver\ValueFactory;

class GetBlogPostsProducts implements ResolverInterface
{

    private ProductCollectionFactory $productCollectionFactory;
    private ValueFactory $valueFactory;

    private ImageBuilder $imageBuilder;

    private $skus = [];

    private $results = [];

    public function __construct(
        ProductCollectionFactory $collectionFactory,
        ValueFactory $valueFactory,
        ImageBuilder $imageBuilder,
        \Magento\Store\Model\App\Emulation $emulation
    ){
        $this->productCollectionFactory = $collectionFactory;
        $this->valueFactory = $valueFactory;
        $this->imageBuilder = $imageBuilder;
    }

    public function resolve(   Field $field,
                                     $context,
                               ResolveInfo $info,
                               array $value = null,
                               array $args = null)
    {

        // No need to hydrate a model
        $skus = $value['skus']??[];

        if(empty($skus)){
            return [];
        }

        $skus = explode(',',$skus);
        $this->skus = array_merge($this->skus,$skus);
        $this->skus = array_unique($this->skus);

        return $this->valueFactory->create(function() use ($value,$skus) {

                $this->loadResults();

                return array_map(function($sku){
                    $data = $this->results[$sku]->getData();
                    return $data;
                },$skus);
            });
    }

    function loadResults(): void
    {
        if(!empty($this->results)){
            return;
        }
        /**
         * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
         */
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToSelect(['sku','image'])->getSelect()->where('sku IN (?)',$this->skus);
        $items = $productCollection->load()->getItems();

        $this->emulation->startEnvironmentEmulation($storeId, \Magento\Framework\App\Area::AREA_FRONTEND, true);
        /**
         * @var $item Product
         */
        foreach ($items as $item){
            $image = $this->imageBuilder->create($item,'category_page_list');
            $this->results[$item->getSku()]=$item;
        }
        $this->emulation->stopEnvironmentEmulation();
    }
}
