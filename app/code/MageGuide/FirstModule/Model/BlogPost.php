<?php

namespace MageGuide\FirstModule\Model;

use MageGuide\FirstModule\Model\ResourceModel\BlogPostResource;
class BlogPost extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(BlogPostResource::class);
    }
}
