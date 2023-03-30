<?php

namespace AHT\Route\Controller\Training\Post;

use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

/**
 * k bao Repository
 */
class Post implements HttpGetActionInterface, HttpPostActionInterface
{
    public function execute()
    {
        echo 'This is test Controller Post/post';
        exit();
    }
}
