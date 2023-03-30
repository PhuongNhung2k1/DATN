<?php

namespace AHT\Route\Controller\Training;

use AHT\Route\Api\Data\PostInterface;
use AHT\Route\Model\PostFactory;
use AHT\Route\Model\PostRepository;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

class Post extends \Magento\Framework\App\Action\Action
{
    protected $_postRepository;
    protected $_postFactory;
    protected $_pageFactory;
    private PostInterface $_postInterface;
    private \AHT\Route\Model\ResourceModel\Post $postResource;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \AHT\Route\Model\PostFactory $postFactory,
        \AHT\Route\Model\ResourceModel\Post $postResource,
        \AHT\Route\Api\PostRepositoryInterface $postRepository,
        PostInterface $postInterface,
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_postFactory = $postFactory;
        $this->postResource = $postResource;
        $this->_postRepository = $postRepository;
        $this->_postInterface=$postInterface;
        return parent::__construct($context);
    }

    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function execute()
    {
        /**
         * get data
         */
        echo $this->testplugin(5,6);
        die();
        $postId = 5;
//        $this->_postRepository->get($postId);
//        return $this->_pageFactory->create();
//
//        /**
//         * delete by ID
//         */
//        $post= $this->_postFactory->create();
//        print_r($post);
//        die();
//
        $this->_postRepository->deleteById(2);
        die();
//        //load data
//        $collection = $post->getCollection();
//        foreach ($collection as $item) {
//            echo "<pre>";
//            print_r($item->getData());
//            echo "</pre>";
//        }

        /**
         * insert data
         */
        $post = $this->_postFactory->create();
        $post->setPostName('Test name repository');
        $post->setPostUrl('test url');
        $post->setPostContent('test content');
        $post->setPostTags('test tag');
        $post->setPostContent('test content');
        $post->setPostStatus('test status');
        $this->_postRepository->save($post);
        $collection = $post->getCollection();
        foreach ($collection as $item) {
            echo "<pre>";
            print_r($item->getData());
            echo "</pre>";
        }
        die();
        /**
         * edit data
         */
        $this->_postRepository->get($postId);
        $post->setPostName('Edit name repository');
        $post->setPostUrl('Edit url');
        $post->setPostContent('Edit content');
        $post->setPostTags('Edit tag');
        $post->setPostContent('Edit content');
        $post->setPostStatus('Edit status');
        $this->_postRepository->save($post);
        $collection = $post->getCollection();
        foreach ($collection as $item) {
            echo "<pre>";
            print_r($item->getData());
            echo "</pre>";
        }

        exit();
        return $this->_pageFactory->create();
    }
    public function testplugin($a, $b)
    {
        $c = $a+$b;
       return $c;
    }
}
