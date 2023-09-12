<?php

namespace MageGuide\SecondModule\Model\Resolver;

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

    private $skus = [];

    private $results = [];

    public function __construct(
        ProductCollectionFactory $collectionFactory,
        ValueFactory $valueFactory
    ){
        $this->productCollectionFactory = $collectionFactory;
        $this->valueFactory = $valueFactory;
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

        return $this->valueFactory->create(function () {

                if(!empty($this->results)){
                    return $this->results;
                }
                /**
                 * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
                 */
                $productCollection = $this->productCollectionFactory->create();
                $productCollection->addAttributeToSelect(['sku','image'])->getSelect()->where('sku IN (?)',$this->skus);
                $this->results = $productCollection->load()->getItems();
                return $this->results;
            });
    }
}
