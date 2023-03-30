<?php
namespace AHT\Extrafee\Model\Quote\Total;

use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Address\Total;

class Fee extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    protected $helperData;
    protected $_priceCurrency;

    /**
     * Collect grand total address amount
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     */
    protected $quoteValidator = null;

    public function __construct(
        \Magento\Quote\Model\QuoteValidator $quoteValidator,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \AHT\Extrafee\Helper\Data $helperData,
    ) {
        $this->quoteValidator = $quoteValidator;
        $this->_priceCurrency = $priceCurrency;
        $this->helperData = $helperData;
    }

    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);
        if (!count($shippingAssignment->getItems())) {
            return $this;
        }

        $enabled = $this->helperData->isModuleEnabled();
        $minimumOrderAmount = $this->helperData->getMinimumOrderAmount();
        $subtotal = $total->getTotalAmount('subtotal');
        if ($enabled && $minimumOrderAmount <= $subtotal) {
            $fee = $this->helperData->getExtrafee();

            $total->setTotalAmount('fee', $fee);
            $total->setBaseTotalAmount('fee', $fee);
            $total->setFee($fee);
            $quote->setFee($fee);

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $productMetadata = $objectManager->get('Magento\Framework\App\ProductMetadataInterface');
            $version = (float)$productMetadata->getVersion();

            if ($version > 2.1) {
                //$total->setGrandTotal($total->getGrandTotal() + $fee);
            } else {
                $total->setGrandTotal($total->getGrandTotal() + $fee);
            }

        }
        return $this;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return array
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $enabled = $this->helperData->isModuleEnabled();
        $minimumOrderAmount = $this->helperData->getMinimumOrderAmount();
        $subtotal = $quote->getSubtotal();
        $fee = $quote->getFee();
        $address = $this->_getAddressFromQuote($quote);

        $result = [];
        if ($enabled && ($minimumOrderAmount <= $subtotal) && $fee) {
            $result = [
                'code' => 'fee',
                'title' => $this->helperData->getFeeLabel(),
                'value' => $fee
            ];
        }

        return $result;
    }

    /**
     * Get Subtotal label
     * Get label defined in admin :fieldName = 'Extra Fee'
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Extra Fee');
    }

    /**
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     */
    protected function _getAddressFromQuote(Quote $quote)
    {
        return $quote->isVirtual() ? $quote->getBillingAddress() : $quote->getShippingAddress();
    }

}
