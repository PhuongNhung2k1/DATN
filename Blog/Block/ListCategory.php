<?php

namespace AHT\Blog\Block;

use AHT\Blog\Model\ResourceModel\Category\Collection;
use AHT\Blog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\View\Element\Template;

class ListCategory extends Template
{
    /**
     * @var CollectionFactory
     */
    private $categoryCollection;

    /**
     * Display constructor.
     * @param Template\Context $context
     * @param CollectionFactory $categoryCollection
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $categoryCollection,
        array $data = []
    ) {
        $this->categoryCollection = $categoryCollection;
        parent::__construct($context, $data);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
//        $this->pageConfig->getTitle()->set(__('Custom Pagination'));
        if ($this->getCustomCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'display.category.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)->setCollection(
                    $this->getCustomCollection()
                );
            $this->setChild('pager', $pager);
            $this->getCustomCollection()->load();
        }
        return $this;
    }
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * @return Collection
     */
    public function getCategories()
    {
        return $this->categoryCollection->create();
    }

    /**
     * @return string
     */

    public function getCategoryById($categoryId)
    {
        return $this->getUrl('blog/post/index', ['category_id' => $categoryId]);
    }

}
