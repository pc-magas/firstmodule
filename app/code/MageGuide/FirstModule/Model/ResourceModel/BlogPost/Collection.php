<?php

namespace MageGuide\FirstModule\Model\ResourceModel\BlogPost;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

use MageGuide\FirstModule\Model\BlogPost as Model;
use MageGuide\FirstModule\Model\ResourceModel\BlogPostResource as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
