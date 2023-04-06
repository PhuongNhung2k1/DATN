<?php

namespace AHT\Blog\Controller\Adminhtml\Post;
class RelatedPostGrid extends Post
{
    /**
     * @return void
     */
    public function execute()
    {
        $this->initModel();
        $this->_view->loadLayout()
            ->getLayout()
            ->getBlock('blog.post.tab.products')
            ->setProductsRelated($this->getRequest()->getPost('products_related'));
        $this->_view->renderLayout();
    }
}
