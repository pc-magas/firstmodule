<?php

namespace MageGuide\FirstModule\Controller\Adminhtml\BlogpostForm;

use MageGuide\FirstModule\Model\BlogPost;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Save extends Action
{
    protected BlogPost $blogPostModel;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        BlogPost $blogPostModel
    ) {
        $this->blogPostModel = $blogPostModel;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        if(empty($data)){
            return $resultRedirect;
        }

        if(isset($data['blogpost'])){
            $data=$data['blogpost'];
        }

        $this->blogPostModel->setTitle($data['title']);
        $this->blogPostModel->setContent($data['post']);

        try{
            $this->blogPostModel->save();
            $this->messageManager->addSuccess(__('The data has been saved.'));
            $resultRedirect->setUrl('adminblogposts/index/index');
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
        } finally {
            return $resultRedirect;
        }
    }

    protected function _isAllowed()
    {
        return true;
    }
}
