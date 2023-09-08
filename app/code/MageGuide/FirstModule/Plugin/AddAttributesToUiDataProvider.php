<?php

namespace MageGuide\FirstModule\Plugin;


use MageGuide\FirstModule\Ui\DataProvider\Blogpost\ListingDataProvider;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class AddAttributesToUiDataProvider
{
    /** @var AttributeRepositoryInterface */
    private $attributeRepository;


    /**
     * Constructor
     *
     * @param AttributeRepositoryInterface $attributeRepository
     * @param ProductMetadataInterface $productMetadata
     */

    public function __construct(
        AttributeRepositoryInterface $attributeRepository
    ) {
        $this->attributeRepository = $attributeRepository;
    }


    /**
     * Get Search Result after plugin
     *
     * @param ListingDataProvider $subject
     * @param SearchResult $result
     * @return SearchResult
     */

    public function afterGetSearchResult(ListingDataProvider $subject, SearchResult $result)
    {
//        if ($result->isLoaded()) {
//            return $result;
//        }
        $result->getSelect();
        return $result;

    }
}
