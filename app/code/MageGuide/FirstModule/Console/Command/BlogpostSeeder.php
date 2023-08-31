<?php

namespace MageGuide\FirstModule\Console\Command;

use MageGuide\FirstModule\Model\BlogPost;
use MageGuide\FirstModule\Model\ResourceModel\BlogPostResource;

use Magento\Framework\App\ObjectManager;

use Symfony\Component\Console\Command\Command;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $progressBar = new ProgressBar($output, self::BLOGPOSTS_NUM);

        for($i=self::BLOGPOSTS_NUM;$i>0;$i--){
            $blogPost = ObjectManager::getInstance()->create(BlogPost::class);
            $blogPost->setTitle("BLogpost ".microtime());
            $blogPost->setBody("BLogpost Body".microtime());
            $resource = $blogPost->getResource();
            $resource->save($blogPost);
            $progressBar->advance();
        }

        $output->writeln("Success");
        return 0;
    }
}
