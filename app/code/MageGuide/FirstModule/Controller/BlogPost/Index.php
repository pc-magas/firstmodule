<?php

namespace MageGuide\FirstModule\Controller\BlogPost;

use MageGuide\FirstModule\Block\BlogPost;
use \Magento\Framework\App\Action\Action;
use \Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\View\Result\Page;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\Exception\LocalizedException;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var BlogPost
     */
    private $blogPost;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param BlogPost $blogPost
     *
     * @codeCoverageIgnore
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory,
        BlogPost $blogPost
    )
    {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
        $this->blogPost = $blogPost;
    }

    /**
     * Prints the statement
     * @return Page
     * @throws LocalizedException
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }

    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $blogPost = $this->blogPost->getBlogPost();
        if(!(bool)(int)$blogPost->getId()){
            throw new \Magento\Framework\Exception\NotFoundException(__('no blog post found'));
        }

        return parent::dispatch($request);
    }

}
