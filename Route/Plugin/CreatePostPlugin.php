<?php

namespace AHT\Route\Plugin;

//use AHT\Route\Controller\Account\CreatePost;
use Magento\Customer\Model\Account\Redirect;

class CreatePostPlugin
{

    //return URL Goodle.com when create account success
    public function afterGetRedirect(Redirect $subject, $result)
    {
        $result->setUrl('https://www.google.com/');
        return $result;
    }
}
