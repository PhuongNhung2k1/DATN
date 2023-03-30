<?php

namespace AHT\Blog\Controller\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class Detail extends Action
{
    private AHT\Blog\Model\PostFactory $postFactory;

    public function execute()
    {
        $this->_view->getPage()->getConfig()->getTitle()->set(__("Blog Post Detail"));
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
