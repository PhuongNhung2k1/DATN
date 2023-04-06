<?php

namespace AHT\Extrafee\Observer;


use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AddFeeToOrderObserver implements ObserverInterface
{
    /**
     * Set payment fee to order
     * Save fee in table sales_order
     *
     * @param EventObserver $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
//        get Order Quote
        $quote = $observer->getQuote();
//        get Order Object
        $order = $observer->getOrder();
        $ExtrafeeFee = $quote->getFee();
        if (!$ExtrafeeFee) {
            return $this;
        }
        $order->setData('fee', $ExtrafeeFee);

        return $this;
    }
}
