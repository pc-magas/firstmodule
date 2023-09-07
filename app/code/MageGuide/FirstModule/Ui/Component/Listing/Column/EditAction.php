<?php

namespace MageGuide\FirstModule\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
class EditAction extends Column
{
    protected UrlInterface $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        $url = $this->getData('editUrl');
        $name = $this->getName();

        foreach ($dataSource['data']['items'] as & $item) {
            $blogpost_id=(int)$item['blog_post_id'];
            $item[$name]=[
                'edit'=>[
                    'href'=>$this->urlBuilder->getUrl($url,[
                        'blogpost_id'=>$blogpost_id
                    ]),
                    'label'=>__('Edit')
                ]
            ];
        }

        return $dataSource;
    }
}
