<?php

namespace AHT\Blog\Model\ResourceModel\Post\Grid;


class Collection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'aht_blog_post_collection';
    protected $_eventObject = 'post_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('AHT\Blog\Model\Post', 'AHT\Blog\Model\ResourceModel\Post');
    }

}
//    private $eavAttribute;
//
//    protected $itemOrder;
//
//    /**
//     * @var \Magento\Ui\DataProvider\AddFilterToCollectionInterface[]
//     */
//    protected $addFilterStrategies;
//
//    public function __construct(
//        Attribute $eavAttribute,
//        ItemOrder $itemOrder,
//        EntityFactory $entityFactory,
//        Logger $logger,
//        FetchStrategy $fetchStrategy,
//        EventManager $eventManager,
//        array $addFilterStrategies = [],
//        $mainTable = 'sales_order_item',
//        $resourceModel = Item::class,
//        $identifierName = null,
//        $connectionName = null
//    )
//    {
//        $this->addFilterStrategies = $addFilterStrategies;
//        $this->itemOrder = $itemOrder;
//        $this->eavAttribute = $eavAttribute;
//        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel, $identifierName, $connectionName);
//    }
//
//    protected function _initSelect()
//    {
//        parent::_initSelect();
//        $this->getSelect()
//            ->joinLeft(
//                ['so' => $this->getTable('sales_order')],
//                'main_table.order_id = so.entity_id',
//                ['main_order' => 'so.increment_id', 'order_date' => 'so.created_at', 'status_main_order' => 'so.status']
//            )->joinLeft(
//                ['cpe' => $this->getTable('catalog_product_entity')],
//                'main_table.product_id = cpe.entity_id',
//                ['product_sku' => 'cpe.sku']
//            )->joinLeft(
//                ['cpev' => $this->getTable('catalog_product_entity_varchar')],
//                "cpe.row_id = cpev.row_id AND cpev.attribute_id = {$this->getProductNameAttributeId()}",
//                ['product_name' => 'cpev.value']
//            )
//            ->where('so.state = ?', Order::STATE_COMPLETE)
//            ->group('main_table.item_id');
//
//        return $this;
//    }
//
//    private function getProductNameAttributeId()
//    {
//        return $this->getProductAttribute('name');
//    }
//
//    private function getProductAttribute($code)
//    {
//        return $this->eavAttribute->getIdByCode(Product::ENTITY, $code);
//    }
//}
