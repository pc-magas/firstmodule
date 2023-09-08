<?php
 namespace MageGuide\FirstModule\Model\Factories\BlogPost;

 use MageGuide\FirstModule\Model\ResourceModel\BlogPost\Collection;

 class CollectionFactory extends \Magento\Framework\Data\CollectionFactory
 {
     public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager)
     {
         parent::__construct($objectManager,Collection::class);
     }
 }
