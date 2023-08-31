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

    private $results;

    public function __construct(
        Template\Context $context,
        BlogPosts $collection,

        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->collection = $collection;
    }


    public function getBlogPosts(): BlogPosts
    {
        $page=($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
        //get values of current limit
        $limit=($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 10;
        return $this->results?? ($this->results=$this->collection->setPageSize($limit)->setCurPage($page)->addOrder('creation_dt','DESC'));
    }

    public function getPaginatedBlogPosts(){

        $limit=($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 10;

        return $this->getLayout()->createBlock(
            'Magento\Theme\Block\Html\Pager',
            'pager'
        )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
            ->setLimit($limit)
            ->setShowPerPage(true)
            ->setCollection($this->getBlogPosts());
    }
}
