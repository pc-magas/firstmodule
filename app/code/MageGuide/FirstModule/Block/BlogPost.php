<?php

namespace MageGuide\FirstModule\Block;

use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Catalog\Block\Product\ImageBuilder;

use MageGuide\FirstModule\Model\BlogPost as BlogPostModel;
use MageGuide\FirstModule\Model\ResourceModel\BlogPost\Collection as BlogPosts;


class BlogPost extends \Magento\Framework\View\Element\Template
{
    /**
     * @var BlogPosts
     */
    private $collection;

    protected ?BlogPostModel $blogPostValue = null;

    private ProductRepository $productRepository;

    private SearchCriteriaBuilder $searchCriteriaBuilder;

    private ImageBuilder $builder;

    public function __construct(
        Template\Context $context,
        ProductRepository $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ImageBuilder $builder,
        BlogPosts $collection,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->collection = $collection;
        $this->productRepository=$productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->builder=$builder;
    }

    public function getBlogPost(): BlogPostModel
    {
        return  $this->blogPostValue ?? (
            $this->blogPostValue = $this->collection
                ->addFieldToFilter('blog_post_id',$this->getRequest()->getParam("blogpost_id"))
                ->getFirstItem()
            );
    }

    public function getRelatedProducts(?array $skus)
    {
          if(empty($skus)){
              return [];
          }

        $searchCriteria = $this->searchCriteriaBuilder->addFilter('sku', $skus, 'in')->create();
        return $this->productRepository->getList($searchCriteria)->getItems();
    }

    public function getImageHtml(Product $product)
    {
        return $this->builder->create($product,'category_page_list')->toHtml();
    }
}
