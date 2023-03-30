<?php

namespace AHT\OrderComment\Plugin;

class OrderComment
{
    public function beforeSetTemplateVars(\Magento\Sales\Model\Order\Email\Container\Template $subject, array $vars)
    {
        /** @var Order $order
         * Declare to sent information in mail customer,
         * check field has get from data and display in email yet.
         * new da co data roi thi get ra va gan lai bien bang du lieu ton tai va tra ve bang
         * trong
         */
        /** @var Order $order */
        $order = $vars['order'];
        if (isset($order['aht_order_comment'])) {
            $vars['has_comment'] = true;
            $vars['aht_order_comment'] = $order['aht_order_comment'];
        } else {
            $vars['has_comment'] = false;
        }

        return [$vars];
    }
}
