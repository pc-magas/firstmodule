<?php

namespace MageGuide\FirstModule\Block\Adminhtml\Edit;

class BackButton extends \Magento\Customer\Block\Adminhtml\Edit\BackButton
{
    public function getBackUrl()
    {
        return $this->getUrl('adminblogposts/index/index');
    }
}
