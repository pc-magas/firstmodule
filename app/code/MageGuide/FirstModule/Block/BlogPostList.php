<?php

namespace MageGuide\FirstModule\Block;

use Magento\Framework\View\Element\Template;
use MageGuide\FirstModule\Model\ResourceModel\BlogPost\Collection as BlogPosts;

class BlogPostList extends \Magento\Framework\View\Element\Template
{
    /**
     * @var BlogPosts
     */
    private $collection;


    public function __construct(
        Template\Context $context,
        BlogPosts $collection,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->collection = $collection;
    }

    public function getAllBlogPosts(): BlogPosts
    {
        return $this->collection;
    }
}
