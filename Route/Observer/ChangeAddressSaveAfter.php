<?php

namespace AHT\Route\Observer;

use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Result\PageFactory;

class ChangeAddressSaveAfter implements ObserverInterface
{
    private PageFactory $addressFactory;
    private $addressRepository;
    public function __construct(
        AddressRepositoryInterface $addressRepository,
        PageFactory $pageFactory,
    ) {
        $this->addressRepository = $addressRepository;
        $this->pageFactory = $pageFactory;
    }

    public function execute(Observer $observer)
    {
        $address = $observer->getData('address');
        $address->setStreet(['AHT Dương Đình Nghệ','']);
        return $this->pageFactory->create();
    }
}
