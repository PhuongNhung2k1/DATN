<?php

namespace AHT\OrderComment\Observer;

use Magento\Framework\DataObject;

class EmailOrderTemplateVarBefore
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var Observer
         * Declare to sent information in mail customer,
         * check field has get from data and display in email yet.
         * new da co data roi thi get ra va gan lai bien bang du lieu ton tai va tra ve bang
         * get $TransportObject in OrderSender and add new attribute in $transport and return in database
         */

        $transportObject = $observer->getTransportObject();
        $transport = $observer->getEvent()->getTransport();
        $order = $transport->getOrder();
        $transportObject->setData('aht_order_comment', $transport['aht_order_comment']);
        $transport->addData([
            'aht_order_comment' => $transport->getTransportObject('aht_order_comment')->getValue()
        ]);
        $transportObject = new DataObject($transport);

        return  $transportObject;
//        --------------------------------------
//        $orderDetail = $this->carrierGroupHelper->getOrderCarrierGroupInfo($order->getId());
//        $transport = [$transportObject];
//        $transport['aht_order_comment'] = $observer->getAhtOrderComment();
//        $transportObject = new DataObject($transport);
    }
}
