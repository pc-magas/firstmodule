<?php

namespace MageGuide\FirstModule\Console\Command;

use MageGuide\FirstModule\Model\BlogPost;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Magento\Framework\App\ObjectManager;
use \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;

/**
 * Seed Multiple Blogposts with Skus
 */
class BlogpostSeeder extends Command
{
    const BLOGPOSTS_NUM=10000;

    protected function configure(): void
    {
        $this->setName('db:seed:blogposts')->setDescription('Seed Multiple Blogposts');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $objectManager = ObjectManager::getInstance();

        /**
         * @var ProductCollectionFactory
         */
        $productCollectionFactory = $objectManager->create(ProductCollectionFactory::class);

        /**
         * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
         */
        $productCollection = $productCollectionFactory->create();
        $productCollection->setPageSize(5);
        $productCollection->getSelect()->orderRand('sku');

        $progressBar = new ProgressBar($output, self::BLOGPOSTS_NUM);
        for($i=self::BLOGPOSTS_NUM;$i>0;$i--){

            $skus = $productCollection->load()->getData();
            $skus = array_map(function($item){return $item['sku'];},$skus);
            /**
             * @var BlogPost
             */
            $blogPost = $objectManager->create(BlogPost::class);
            $blogPost->setTitle("BLogpost ".microtime());
            $blogPost->setPost("BLogpost Body".microtime());
            $blogPost->setSkus($skus);
            $resource = $blogPost->getResource();
            $resource->save($blogPost);
            $progressBar->advance();
        }

        $output->writeln("Success");
        return 0;
    }
}
