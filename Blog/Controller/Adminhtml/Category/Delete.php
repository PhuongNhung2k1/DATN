<?php

namespace AHT\Blog\Controller\Adminhtml\Category;

use Exception;
use Magento\Backend\App\Action;
use AHT\Blog\Model\CategoryFactory;
use AHT\Blog\Model\ResourceModel\Category;

class Delete extends Action
{
    private $categoryFactory;
    private $categoryResourceModel;

    public function __construct(
        Action\Context $context,
        CategoryFactory $categoryFactory,
        Category $categoryResourceModel
    )
    {
        parent::__construct($context);
        $this->categoryFactory = $categoryFactory;
        $this->categoryResourceModel = $categoryResourceModel;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');

        if ($id) {
            try {
                // init model and delete
                $category = $this->categoryFactory->create();
                $this->categoryResourceModel->load($category, $id);
                $this->categoryResourceModel->delete($category);
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the category.'));
                return $this->resultRedirectFactory->create()->setPath('blog/category/index');
            } catch (Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a category to delete.'));

        return $this->resultRedirectFactory->create()->setPath('blog/category/index');
    }
}
