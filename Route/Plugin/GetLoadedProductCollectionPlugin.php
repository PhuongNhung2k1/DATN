<?php

namespace AHT\Route\Plugin;
use Magento\Catalog\Block\Product\ListProduct;
class GetLoadedProductCollectionPlugin
{
    public function afterLoadedProductCollectionPlugin(ListProduct $subject, $result){
    return $result ;
    }
}
