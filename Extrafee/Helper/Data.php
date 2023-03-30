<?php

namespace AHT\Extrafee\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * Custom fee config path
     * Create config for admin pages
     */
    const CONFIG_CUSTOM_IS_ENABLED = 'Extrafee/Extrafee/status';
    const CONFIG_CUSTOM_FEE = 'Extrafee/Extrafee/Extrafee_amount';
    const CONFIG_FEE_LABEL = 'Extrafee/Extrafee/name';
    const CONFIG_MINIMUM_ORDER_AMOUNT = 'Extrafee/Extrafee/minimum_order_amount';

    /**
     * @return mixed
     */
    public function isModuleEnabled()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::CONFIG_CUSTOM_IS_ENABLED, $storeScope);
    }

    /**
     * Get custom fee
     *
     * @return mixed
     */
    public function getExtrafee()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::CONFIG_CUSTOM_FEE, $storeScope);
    }

    /**
     * Get custom fee label
     *
     * @return mixed
     */
    public function getFeeLabel()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::CONFIG_FEE_LABEL, $storeScope);
    }

    /**
     * get amount order
     * @return mixed
     */
    public function getMinimumOrderAmount()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::CONFIG_MINIMUM_ORDER_AMOUNT, $storeScope);
    }
}

