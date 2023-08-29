<?php

namespace MageGuide\FirstModule\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class BlogPostResource extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('blog_posts', 'blog_post_id');
    }
}
