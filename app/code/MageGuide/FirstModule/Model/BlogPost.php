<?php

namespace MageGuide\FirstModule\Model;

use MageGuide\FirstModule\Model\ResourceModel\BlogPostResource;
class BlogPost extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(BlogPostResource::class);
    }

    public function getSkus():array
    {
        $skus=$this->getData('skus')??"";
        $skus=explode(',',$skus);
        $skus=array_map('trim',$skus);
        $skus=array_filter($skus);
        return $skus;
    }

    public function setTitle(string $title)
    {
        return $this->setData('title',strip_tags($title));
    }

}
