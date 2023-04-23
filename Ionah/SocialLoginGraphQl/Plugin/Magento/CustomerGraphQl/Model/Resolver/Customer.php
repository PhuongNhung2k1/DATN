<?php

namespace Ionah\SocialLoginGraphQl\Plugin\Magento\CustomerGraphQl\Model\Resolver;

use Magenest\SocialLogin\Model\ResourceModel\SocialAccount\Collection;
use Magento\CustomerGraphQl\Model\Resolver\Customer as MagentoCustomer;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magenest\SocialLogin\Model\ResourceModel\SocialAccount\CollectionFactory;
use Magenest\SocialLogin\Helper\SocialLogin;
use Magento\Framework\UrlInterface;
use Ionah\SocialLoginGraphQl\Helper\Data as HelperData;

class Customer
{
    const SOCIAL_ALLOW = ['google', 'facebook'];
    /**
     * @var CollectionFactory
     */
    protected $socialAccountCollection;

    /**
     * @var SocialLogin
     */
    protected $socialLoginHelper;

    /**
     * @var UrlInterface
     */
    protected $urlInterface;

    /**
     * @var HelperData
     */
    protected $helperData;

    /**
     * Customer constructor.
     *
     * @param CollectionFactory $socialAccountCollection
     * @param SocialLogin $socialLoginHelper
     * @param UrlInterface $urlInterface
     * @param HelperData $helperData
     */
    public function __construct(
        CollectionFactory $socialAccountCollection,
        SocialLogin $socialLoginHelper,
        UrlInterface $urlInterface,
        HelperData $helperData
    ) {
        $this->socialAccountCollection = $socialAccountCollection;
        $this->socialLoginHelper = $socialLoginHelper;
        $this->urlInterface = $urlInterface;
        $this->helperData = $helperData;
    }

    public function afterResolve(
        MagentoCustomer $subject,
        $result,
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $socialLinks = $this->_initSocialLink();

        if ($context->getUserId()) {

            $socialLinked = $this->getAllAccounts($context->getUserId());
            foreach ($socialLinked as $item) {
                $itemType = $item->getSocialLoginType();
                if (in_array($itemType, $this->getSocialAllow())) {
                    $socialLinks[$itemType]['social_login_id'] = $item->getSocialLoginId();
                    $socialLinks[$itemType]['social_login_type'] = $itemType;
                    $socialLinks[$itemType]['social_email'] = $item->getSocialEmail();
                    $socialLinks[$itemType]['exist_email'] = $item->getExistEmail();
                    $socialLinks[$itemType]['created_at'] = $item->getCreatedAt();
                    $socialLinks[$itemType]['last_login'] = $item->getLastLogin();
                    $socialLinks[$itemType]['btn_url'] = $this->getButtonUrl($itemType, true);
                    $socialLinks[$itemType]['linked'] = true;
                    $socialLinks[$itemType]['icon'] = $this->helperData->getSocialIcon($itemType);
                    $socialLinks[$itemType]['label'] = $this->helperData->getSocialLabel($itemType);
                }
            }
        }
        $result['social_links'] = $socialLinks;
        return $result;
    }

    /**
     * @param $customerId
     * @return Collection
     */
    private function getAllAccounts($customerId)
    {
        $socialCustomerCollection = $this->socialAccountCollection->create();
        $socialCustomerCollection->addFieldToFilter('customer_id', $customerId);
        $socialCustomerCollection->addFieldToFilter('social_login_type', ['IN' => $this->getSocialAllow()]);
        return $socialCustomerCollection;
    }


    /**
     * @return string
     */
    public function getButtonUrl($type, $unlink = false)
    {
        $action = 'sociallogin/index/socialUrl';
        $key = 'social';
        if ($unlink) {
            $action = 'sociallogin/customer/unlink';
            $key = 'type';
        }

        return $this->urlInterface->getUrl($action, [$key => $type]);
    }

    private function getSocialAllow()
    {
        return self::SOCIAL_ALLOW;
    }

    private function _initSocialLink()
    {
        $socialLinks = [];
        foreach ($this->getSocialAllow() as $socialType) {
            $socialLinks[$socialType] = [
                'linked' => false,
                'icon' => $this->helperData->getSocialIcon($socialType),
                'label' => $this->helperData->getSocialLabel($socialType)
            ];
        }
        return $socialLinks;
    }
}
