<?php
namespace AHT\Extrafee\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Quote\Model\Quote;

/**
 * Helpers are classes that provide functionalities
 * for various features throughout the Magento website.
 * Available for use anywhere on the website,
 * Magento 2 Helper can be called in controllers, views, models and even in other helpers too!
 */
class ExtrafeeConfigProvider implements ConfigProviderInterface
{
    /**
     * @var \AHT\Extrafee\Helper\Data
     */
    protected $dataHelper;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \AHT\Extrafee\Helper\Data $dataHelper
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \AHT\Extrafee\Helper\Data $dataHelper,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Psr\Log\LoggerInterface $logger,
    ) {
        $this->dataHelper = $dataHelper;
        $this->checkoutSession = $checkoutSession;
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        /**
         * create array null for save data
         * get data from dataHelper called function defined.
        */

        $ExtrafeeConfig = [];
        $enabled = $this->dataHelper->isModuleEnabled();
        $minimumOrderAmount = $this->dataHelper->getMinimumOrderAmount();
        $ExtrafeeConfig['fee_label'] = $this->dataHelper->getFeeLabel();
//        get data from quote in shipping or cart

        $quote = $this->checkoutSession->getQuote();
        $subtotal = $quote->getSubtotal();
        $ExtrafeeConfig['custom_fee_amount'] = $this->dataHelper->getExtrafee();
        $ExtrafeeConfig['show_hide_Extrafee_block'] = ($enabled && ($minimumOrderAmount <= $subtotal) && $quote->getFee()) ? true : false;
        $ExtrafeeConfig['show_hide_Extrafee_shipblock'] = ($enabled && ($minimumOrderAmount <= $subtotal)) ? true : false;
        return $ExtrafeeConfig;
    }

}
