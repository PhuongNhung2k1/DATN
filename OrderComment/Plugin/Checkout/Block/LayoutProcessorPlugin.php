<?php

namespace AHT\OrderComment\Plugin\Checkout\Block;

class LayoutProcessorPlugin
{
    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {

        // display sort order to display field in frontend.

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['aht_order_comment'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'options' => [],
                'id' => 'aht-order-comment'
            ],
            'dataScope' => 'shippingAddress.custom_attributes.custom_field_text',
            'label' => 'Custom Field Text Note',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [
                'required-entry' => true
            ],
            'sortOrder' => 250,
            /*'customEntry' => null,*/
            'id' => 'aht-order-comment'
        ];

        return $jsLayout;
    }
}
