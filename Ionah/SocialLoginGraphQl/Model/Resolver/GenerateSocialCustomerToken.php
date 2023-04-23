<?php


namespace Ionah\SocialLoginGraphQl\Model\Resolver;

use Exception;
use GraphQL\Error\Error;
use Ionah\SocialLoginGraphQl\Model\Resolver\DataProvider\SocialCustomer;
use Magenest\SocialLogin\Helper\SocialLogin;
use Magenest\SocialLogin\Model\Resolver\DataProvider\GenerateSocialCustomerToken as DataProviderGenerateSocialCustomerToken;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthenticationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Integration\Helper\Oauth\Data as OauthHelper;

class GenerateSocialCustomerToken implements ResolverInterface
{

    /**
     * @var DataProvider\GenerateSocialCustomerToken
     */
    private $generateSocialCustomerTokenDataProvider;

    /**
     * @var OauthHelper
     */
    private $oauthHelper;

    protected $socialHelper;
    /**
     * @var DataProvider\SocialCustomer
     */
    private $socialCustomer;

    /**
     * @param DataProviderGenerateSocialCustomerToken $generateSocialCustomerTokenDataProvider
     * @param SocialLogin $socialHelper
     * @param OauthHelper $oauthHelper
     */
    public function __construct(
        DataProviderGenerateSocialCustomerToken $generateSocialCustomerTokenDataProvider,
        SocialLogin $socialHelper,
        OauthHelper $oauthHelper,
        SocialCustomer $socialCustomer
    ) {
        $this->generateSocialCustomerTokenDataProvider = $generateSocialCustomerTokenDataProvider;
        $this->oauthHelper = $oauthHelper;
        $this->socialHelper = $socialHelper;
        $this->socialCustomer = $socialCustomer;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {

        if (!$this->socialHelper->getAllTypeOptionsAcceptedForApi($args["type"])) {
            throw new GraphQlAuthenticationException(__('type should be only ["facebook","google","amazon","instagram","line","linkedin","reddit","twitter","zalo","apple"]'));
        }

        try {
            $token = $this->socialCustomer->getCustomerToken($args["access_token"], $args["type"]);

            return [
                'expired_after_hours' => $this->oauthHelper->getCustomerTokenLifetime(),
                'token' => $token
            ];
        } catch (Exception $e) {
            throw new GraphQlAuthenticationException(__($e->getMessage()));
        }
    }
}


