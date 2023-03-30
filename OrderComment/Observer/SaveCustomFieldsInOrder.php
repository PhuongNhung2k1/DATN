<?php

namespace AHT\OrderComment\Observer;

use AHT\OrderComment\Model\Data\OrderComment;

class SaveCustomFieldsInOrder implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();

//        $order->setData('custom_field_text', $quote->getCustomFieldText());
        $order->setData(OrderComment::COMMENT_FIELD_NAME, $quote->getData(OrderComment::COMMENT_FIELD_NAME));

        return $this;
    }
}
