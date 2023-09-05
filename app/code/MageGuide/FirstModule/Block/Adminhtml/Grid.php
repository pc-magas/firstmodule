<?php

namespace MageGuide\FirstModule\Block\Adminhtml;

use MageGuide\FirstModule\Model\Factories\BlogPost\CollectionFactory as BlogPostCollectionFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magento\Framework\ObjectManagerInterface;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Framework\Registry;


class Grid extends Extended
{
// also you can use Magento Default CollectionFactory

    protected $registry;
    protected $_objectManager = null;
    protected BlogPostCollectionFactory $demoFactory;

    public function __construct(
        Context $context,
        Data $backendHelper,
        Registry $registry,
        ObjectManagerInterface $objectManager,
        BlogPostCollectionFactory $demoFactory,
        array $data = []
    ) {
        $this->_objectManager = $objectManager;
        $this->registry = $registry;
        $this -> demoFactory = $demoFactory;
        parent::__construct($context, $backendHelper, $data);
    }
    protected function _construct()
    {
        parent::_construct();
        $this->setId('blog_post_id');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }
    protected function _prepareCollection()
    {
        $demo = $this->demoFactory->create()
            ->addFieldToSelect('*');

        $demo->addFieldToFilter('blog_post_id', array('neq' => ''));

        $this->setCollection($demo);

        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {

        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'blog_post_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'title',
            [
                'header' => __('Blog Post Title'),
                'type' => 'text',
                'index' => 'title',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );

        $this->addColumn(
            'skus',
            [
                'header' => __('Product Skus'),
                'type' => 'text',
                'index' => 'skus',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );

        $this->addColumn(
            'created_at',
            [
                'header' => __('Created At'),
                'index' => 'creation_dt',
                'type' => 'datetime',
            ]
        );

        $this->addColumn(
            'updated_at',
            [
                'header' => __('Last Update Datetime'),
                'index' => 'update_dt',
                'type' => 'datetime',
            ]
        );

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/actionName', ['_current' => true]);
    }
}
