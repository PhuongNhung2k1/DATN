<?php
namespace AHT\OrderComment\Observer;

use AHT\OrderComment\Model\Data\OrderComment;
use Magento\Framework\DataObject;

class AddOrderCommentToOrder implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * transfer the order comment from the quote object to the order object during the
     * sales_model_service_quote_submit_before event
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /* @var $order \Magento\Sales\Model\Order
         * add to quote bang
         */
        $order = $observer->getEvent()->getOrder();

        /** @var $quote \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getEvent()->getQuote();

        $order->setData(OrderComment::COMMENT_FIELD_NAME, $quote->getData(OrderComment::COMMENT_FIELD_NAME));
    }
}
