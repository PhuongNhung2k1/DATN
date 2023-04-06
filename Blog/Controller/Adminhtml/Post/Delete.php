<?php

namespace AHT\Blog\Controller\Adminhtml\Post;

use AHT\Blog\Model\PostFactory;
use AHT\Blog\Model\ResourceModel\Post;
use Exception;
use Magento\Backend\App\Action;

class Delete extends Action
{
    private $postFactory;
    private $postResourceModel;

    public function __construct(
        Action\Context $context,
        PostFactory $postFactory,
        Post $postResourceModel
    ) {
        parent::__construct($context);
        $this->postFactory = $postFactory;
        $this->postResourceModel = $postResourceModel;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');

        if ($id) {
            try {
                // init model and delete
                $post = $this->postFactory->create();
                $this->postResourceModel->load($post, $id);
                $this->postResourceModel->delete($post);
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the post.'));
                return $this->resultRedirectFactory->create()->setPath('blog/post/index');
            } catch (Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a post to delete.'));

        return $this->resultRedirectFactory->create()->setPath('blog/post/index');
    }
}
