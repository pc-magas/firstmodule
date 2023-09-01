<?php

namespace MageGuide\FirstModule\Controller\Adminhtml\Index;

use MageGuide\FirstModule\Block\Adminhtml\Grid as AdminGrid;

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
        $this->_addContent($this->_view->getLayout()->createBlock(AdminGrid::class));
        $this->_view->renderLayout();
    }
    protected function _isAllowed()
    {
        return true;
    }
}
