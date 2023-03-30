<?php

namespace AHT\Route\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ChangeDisplayLoginPost implements ObserverInterface
{
    protected $_postRepository;
    protected $postFactory;
    public function __construct(
        \AHT\Route\Api\PostRepositoryInterface $postRepository,
        \AHT\Route\Model\PostFactory $postFactory,
    ) {
        $this->_postRepository = $postRepository;
        $this->postFactory=$postFactory;
    }

    public function execute(Observer $observer)
    {
        /**Create 14/02
         * Is Controleler AHT/Route/TRaining/Post is defined a 'dispatch' for getRedirect
         * So in the file observer will understand and can uer , call again
         * Return   $observer->getIsRedirect();
        */


        $customer = $observer->getEvent()->getCustomer();
        $customerLastName = $customer->getLastname();
        $customerFirstName = $customer->getFirstname();
        $customerFullName = $customerFirstName .' '. $customerLastName;
        $post = $this->postFactory->create();
        $post->setPostContent($customerFullName);
        $this->_postRepository->save($post);


//        $displayText = $observer->getData('mp_text');
//        echo $displayText->getText() . " - Event </br>";
//        $displayText->setText('Execute event successfully.');
//        return $this;
    }
}
