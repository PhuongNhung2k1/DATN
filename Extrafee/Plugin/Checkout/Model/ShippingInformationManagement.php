<?php

namespace AHT\ExtraFee\Plugin\Checkout\Model;

class ShippingInformationManagement
{
    /**
     * @var \Magento\Quote\Model\QuoteRepository
     */
    protected $quoteRepository;

    /**
     * @var \AHT\Extrafee\Helper\Data
     */
    protected $dataHelper;

    /**
     * @param \AHT\Quote\Model\QuoteRepository $quoteRepository
     * @param \AHT\Extrafee\Helper\Data $dataHelper
     */
    public function __construct(
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        \AHT\Extrafee\Helper\Data       $dataHelper
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->dataHelper = $dataHelper;
    }

    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param $cartId
     * @param \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement   $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
        $Extrafee = $addressInformation->getExtensionAttributes()->getFee();
        $quote = $this->quoteRepository->getActive($cartId);
        if ($Extrafee) {
            $fee = $this->dataHelper->getExtrafee();
            $quote->setFee($fee);
        } else {
            $quote->setFee(null);
        }
    }
}
