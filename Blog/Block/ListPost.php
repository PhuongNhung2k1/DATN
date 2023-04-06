<?php

namespace AHT\Blog\Block;

use AHT\Blog\Controller\Router;
use AHT\Blog\Model\ResourceModel\Post\Collection;
use AHT\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Element\Template;

class ListPost extends Template
{
    const ENABLE = 1;
    /**
     * @var CollectionFactory
     */
    private $postCollection;
    protected $date;
    protected $router;
    protected $timezoneInterface;

    /**
     * Display constructor.
     * @param Template\Context $context
     * @param CollectionFactory $postCollection
     * @param array $data
     */
    public function __construct(
        Template\Context                            $context,
        CollectionFactory                           $postCollection,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        TimezoneInterface                           $timezoneInterface,
        Router                                      $router,
        array                                       $data = []
    ) {
        $this->postCollection = $postCollection;
        $this->date = $date;
        $this->router = $router;
        $this->timezoneInterface = $timezoneInterface;
        parent::__construct($context, $data);
    }

    /**
     * @return Collection
     */

    public function getPosts()
    {
        //get values of current page
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        //get values of current limit
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;

        //declare to filter
        $collection = $this->postCollection->create();
        // status = enable
        $collection->addFieldToFilter('status', ['eq' => self::ENABLE]);
        // filter date <= curent date
        $collection->addFieldToFilter('publish_date', ['lteq' => $this->timezoneInterface->date()->format('Y-m-d H:i:s')]);
        if ($this->getRequest()->getParam('category_id')) {
            $cateId = $this->getRequest()->getParam('category_id');
            $collection->loadPostByCategory($cateId);
        }

        // get param for key = url
        if ($this->getRequest()->getParam('key')) {
            $namePost = $this->getRequest()->getParam('key');
            $collection->addFieldToFilter('name', ['like' => '%' . $namePost . '%']);
        } else {
        }

        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);

        return $collection;
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getPosts()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'test.posts.pager'
            )->setAvailableLimit([3 => 3, 5 => 5, 10 => 10])->setShowPerPage(true)->setCollection(
                $this->getPosts()
            );
            $this->setChild('pager', $pager);
            $this->getPosts()->load();
        }
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getUrlPost($postId)
    {
        return $this->getUrl('blog/post/detail', ['post_id' => $postId]);
    }

    public function getImageUrl($image)
    {
        return $this->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . '/media/' . $image;
    }
}
