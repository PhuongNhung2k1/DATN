<?php

namespace Ionah\SocialLoginGraphQl\Model\Resolver;

use Ionah\SocialLoginGraphQl\Model\Resolver\DataProvider\SocialCustomer;
use Magento\CustomerGraphQl\Model\Customer\ExtractCustomerData;
use Magento\CustomerGraphQl\Model\Customer\GetCustomer;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextInterface;
use Magento\Customer\Model\CustomerFactory;
use Ionah\SocialLoginGraphQl\Helper\Data as HelperData;

class CustomerSocialLink implements ResolverInterface
{
    /**
     * @var GetCustomer
     */
    private $getCustomer;

    /**
     * @var ExtractCustomerData
     */
    private $extractCustomerData;

    /**
     * @var SocialCustomer
     */
    private $socialCustomer;

    /**
     * @var CustomerFactory
     */
    private $customerFactory;

    /**
     * @var HelperData
     */
    private $helperData;

    /**
     * @param GetCustomer $getCustomer
     * @param ExtractCustomerData $extractCustomerData
     * @param SocialCustomer $socialCustomer
     * @param CustomerFactory $customerFactory
     * @param HelperData $helperData
     */
    public function __construct(
        GetCustomer $getCustomer,
        ExtractCustomerData $extractCustomerData,
        SocialCustomer $socialCustomer,
        CustomerFactory $customerFactory,
        HelperData $helperData
    ) {
        $this->getCustomer = $getCustomer;
        $this->extractCustomerData = $extractCustomerData;
        $this->socialCustomer = $socialCustomer;
        $this->customerFactory = $customerFactory;
        $this->helperData = $helperData;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        /** @var ContextInterface $context */
        if (false === $context->getExtensionAttributes()->getIsCustomer()) {
            throw new GraphQlAuthorizationException(__('The current customer isn\'t authorized.'));
        }

        $websiteId = $context->getExtensionAttributes()->getStore()->getWebsiteId();
        $userInfo = $this->socialCustomer->getUserInfo($args['access_token'], $args['type']);
        $customer = $this->getCustomer->execute($context);
        $this->validate($userInfo, $customer, $websiteId);
        $this->socialCustomer->updateSocialCustomer($userInfo, $customer->getId());
        $socialInfo = [
            'icon' => $this->helperData->getSocialIcon($userInfo['type']),
            'label' => $this->helperData->getSocialLabel($userInfo['type'])
        ];
        return array_merge($socialInfo, $userInfo);
    }

    /**
     * @throws GraphQlInputException
     * @throws GraphQlAuthorizationException
     */
    public function validate($socialUser, $customer, $websiteId)
    {
        /** @var \Magento\Customer\Api\Data\CustomerInterface $customer */
        if (!$customer->getId()) {
            throw new GraphQlAuthorizationException(__('Customer does not exist.'));
        }

        if ($this->getCustomerByEmail($socialUser['email'], $websiteId)
            && $customer->getEmail() != $socialUser['email']) {
            throw new GraphQlInputException(__('Email already used by another customer.'));
        }
    }

    public function getCustomerByEmail($email, $websiteId)
    {
        try {
            $customer = $this->customerFactory->create()->setWebsiteId($websiteId)->loadByEmail($email);
            return $customer->getId();
        } catch (\Exception $e) {
            return false;
        }
    }
}
