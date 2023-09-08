<?php

namespace MageGuide\FirstModule\Controller\Adminhtml\BlogpostForm;

use MageGuide\FirstModule\Model\BlogPost;

use MageGuide\FirstModule\Model\ResourceModel\BlogPost\Collection;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Save extends Action
{
    protected BlogPost $blogPostModel;
    protected Collection $blogPostCollection;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        BlogPost $blogPostModel,
        Collection $blogPostCollection
    ) {
        $this->blogPostModel = $blogPostModel;
        $this->blogPostCollection = $blogPostCollection;
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

        $blogPostModel = !empty($data['blog_post_id'])?$this->blogPostCollection->addFieldToFilter('blog_post_id',$data['blog_post_id'])->load()->getFirstItem():$this->blogPostModel;

        if(empty($blogPostModel)){
            $this->messageManager->addSuccess(__('Νο blog post model has been found'));
            $resultRedirect->setUrl('adminblogposts/index/index');
            return $resultRedirect;
        }

        $blogPostModel->setTitle($data['title']);
        $blogPostModel->setPost($data['post']);

        try{
            $blogPostModel->save();
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
