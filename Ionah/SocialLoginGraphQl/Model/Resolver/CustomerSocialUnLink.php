<?php

namespace Ionah\SocialLoginGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magenest\SocialLogin\Model\ResourceModel\SocialAccount\CollectionFactory as SocialCollectionFactory;
use Magento\GraphQl\Model\Query\ContextInterface;

class CustomerSocialUnLink implements ResolverInterface
{
    /**
     * @var SocialCollectionFactory
     */
    private $socialCollectionFactory;

    public function __construct(
        SocialCollectionFactory $socialCollectionFactory
    ) {
        $this->socialCollectionFactory = $socialCollectionFactory;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        /** @var ContextInterface $context */
        if (false === $context->getExtensionAttributes()->getIsCustomer()) {
            throw new GraphQlAuthorizationException(__('The current customer isn\'t authorized.'));
        }
        if (!isset($args['type'])) {
            throw new GraphQlInputException(__('Type param is required'));
        }
        $response = [
            'is_unlinked' => true,
            'message' => __('Unlink successful')
        ];
        try {
            $customerId = $context->getUserId();
            $collection = $this->socialCollectionFactory->create();
            $collection->addFieldToFilter('customer_id', $customerId);
            $collection->addFieldToFilter('social_login_type', $args['type']);
            foreach ($collection as $social) {
                $social->delete();
            }
        } catch (\Exception $e) {
            $response = [
                'is_unlinked' => false,
                'message' => __('Unlink failed')
            ];
        }
        return $response;
    }
}
