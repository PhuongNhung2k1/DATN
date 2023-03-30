<?php

namespace AHT\Blog\Controller\Adminhtml\Category;

use AHT\Blog\Api\CategoryRepositoryInterface;
use AHT\Blog\Model\Category\CategoryRepository;
use AHT\Blog\Model\CategoryFactory;
use AHT\Blog\Model\ResourceModel\Category;
use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\Action;

/**
 * Save CMS block action.
 */
class Save extends Action
{
    /**
     * @var CategoryFactory
     */
    private $categoryFactory;
    private $categoryResourceModel;

    private CategoryRepositoryInterface $categoryRepository;
    /**
     * @param Context $context
     * @param CategoryFactory|null $categoryFactory
     */
    public function __construct(
        Context $context,
        CategoryFactory $categoryFactory,
        Category $categoryResourceModel,
        CategoryRepositoryInterface $categoryRepository,
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->categoryResourceModel = $categoryResourceModel;
        $this->categoryRepository = $categoryRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $id = !empty($data['entity_id']) ? $data['entity_id'] : null;

        $category = $this->categoryFactory->create();

        if ($id) {
//            $this->categoryRepository->get($id);
            $this->categoryResourceModel->load($category, $id);
        }
        try {
            $category->setData($data);
            $this->categoryResourceModel->save($category);
            $this->messageManager->addSuccessMessage(__('You saved the category.'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        return $this->resultRedirectFactory->create()->setPath('blog/category/index');
    }
}
