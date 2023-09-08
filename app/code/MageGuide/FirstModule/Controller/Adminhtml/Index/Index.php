<?php

namespace MageGuide\FirstModule\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    public function execute()
    {
        $this->_view->loadLayout();
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('BlogPosts'));
        $resultPage->setActiveMenu('MageGuide_FirstModule::home');
        $resultPage->addBreadcrumb(__('BlogPosts'), __('BlogPosts'));
        $this->_view->renderLayout();
    }
    protected function _isAllowed()
    {
        return true;
    }
}
