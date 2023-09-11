<?php

namespace MageGuide\SecondModule\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class GetBlogPostsProducts implements ResolverInterface
{
    public function resolve(   Field $field,
                                     $context,
                               ResolveInfo $info,
                               array $value = null,
                               array $args = null)
    {

        return [
            [
                'sku'=>1234,
                'image'=>'https://example.com/image.png'
            ]
        ];
    }
}
