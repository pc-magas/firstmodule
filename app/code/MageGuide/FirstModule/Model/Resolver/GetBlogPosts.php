<?php

namespace MageGuide\FirstModule\Model\Resolver;

use MageGuide\FirstModule\Model\ResourceModel\BlogPost\Collection as BlogPosts;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class GetBlogPosts implements ResolverInterface
{

    protected BlogPosts $collection;

    public function __construct(BlogPosts $collection){
        $this->collection=$collection;
    }
    public function resolve(   Field $field,
                                     $context,
                               ResolveInfo $info,
                               array $value = null,
                               array $args = null)
    {

        // @TODO Get page and limit from graphql
        $page = $args['input']['page']>0?$args['input']['page']:1;
        $limit = $args['input']['limit']>0?$args['input']['limit']:10;

        $results = $this->collection
                ->setPageSize($limit)
                ->setCurPage($page)
                ->addOrder('creation_dt','DESC');

        return $results->load()->getData();
    }
}
