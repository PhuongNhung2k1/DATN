<?php

namespace AHT\Blog\Model\Post;

use AHT\Blog\Model\ResourceModel\Post\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $_loadedData;
    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    // khai bao ham de lay ra du lieu co trong phan description

    public function getDescription(){

    }

    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $post) {
            $this->_loadedData[$post->getId()] = $post->getData();
        }
        return $this->_loadedData;
    }

    private function convertValues($post, $postData): array
    {
        foreach ($post->getAttributes() as $attributeCode => $attribute) {
            if ($attributeCode === 'custom_layout_update_file') {
                if (!empty($postData['custom_layout_update'])) {
                    $postData['custom_layout_update_file']
                        = LayoutUpdate::VALUE_USE_UPDATE_XML;
                }
            }
            if (!isset($postData[$attributeCode])) {
                continue;
            }

            if ($attribute->getBackend() instanceof ImageBackendModel) {
                unset($postData[$attributeCode]);

                $fileName = $post->getData($attributeCode);

                if ($this->fileInfo->isExist($fileName)) {
                    $stat = $this->fileInfo->getStat($fileName);
                    $mime = $this->fileInfo->getMimeType($fileName);

                    // phpcs:ignore Magento2.Functions.DiscouragedFunction
                    $postData[$attributeCode][0]['name'] = basename($fileName);

                    $postData[$attributeCode][0]['url'] = $this->postImage->getUrl($post, $attributeCode);

                    $postData[$attributeCode][0]['size'] = isset($stat) ? $stat['size'] : 0;
                    $postData[$attributeCode][0]['type'] = $mime;
                }
            }
        }

        return $postData;
    }
}
