<?php

namespace MageGuide\FirstModule\Block;

use Magento\Framework\View\Element\Template;

use MageGuide\FirstModule\Model\BlogPost as BlogPostModel;
use MageGuide\FirstModule\Model\ResourceModel\BlogPost\Collection as BlogPosts;

class BlogPost extends \Magento\Framework\View\Element\Template
{
    /**
     * @var BlogPosts
     */
    private $collection;

    protected ?BlogPostModel $blogPostValue = null;

    public function __construct(
        Template\Context $context,
        BlogPosts $collection,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->collection = $collection;
    }

    public function getBlogPost(): BlogPostModel
    {
        return  $this->blogPostValue ?? (
            $this->blogPostValue = $this->collection
                ->addFieldToFilter('blog_post_id',$this->getRequest()->getParam("blogpost_id"))
                ->getFirstItem()
            );
    }
}
