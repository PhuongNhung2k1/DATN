<?php


namespace Ionah\SocialLoginGraphQl\Model\Resolver\DataProvider;


use Exception;
use Magenest\SocialLogin\Helper\SocialLogin;
use Magento\Customer\Model\Customer;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\ObjectManagerInterface;
use Magento\Integration\Model\Oauth\TokenFactory;
use Ionah\SocialLoginGraphQl\Helper\Data as HelperData;

class SocialCustomer
{
    const XML_PATH_ENABLE_CONFIRMATION_REQUIRED = 'magenest/credentials/%s/is_confirmation_required';
    public $clientObject = [
        'facebook' => 'Ionah\SocialLoginGraphQl\Model\Facebook\Client',
        'google' => 'Ionah\SocialLoginGraphQl\Model\Google\Client',
        'zalo' => 'Ionah\SocialLoginGraphQl\Model\Zalo\Client',
    ];
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var SocialLogin
     */
    private $socialHelper;

    /**
     * @var TokenFactory
     */
    private $tokenModelFactory;

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var HelperData
     */
    private $helperData;

    public function __construct(
        ObjectManagerInterface $objectManager,
        SocialLogin $socialHelper,
        TokenFactory $tokenModelFactory,
        ResourceConnection $resourceConnection,
        HelperData $helperData
    ) {
        $this->objectManager = $objectManager;
        $this->socialHelper = $socialHelper;
        $this->tokenModelFactory = $tokenModelFactory;
        $this->resourceConnection = $resourceConnection;
        $this->helperData = $helperData;
    }

    public function getUserInfo($accessToken, $type)
    {
        $client = $this->objectManager->create($this->clientObject[$type]);
        $user = $client->getUserInfo($accessToken);
        $userInfo = [
            'type' => $type,
            'password' => $user['password'] ?? '',
            'social_login_id' => $user['id'],
            'exist_email' => isset($user['email'])
        ];
        return array_merge($user, $userInfo);
    }

    public function getCustomerToken($accessToken, $type)
    {
        $userInfo = $this->getUserInfo($accessToken, $type);
        $customer = $this->prepareCustomer($userInfo, $type);
        $customerToken = $this->tokenModelFactory->create()->createCustomerToken($customer->getId());
        return $customerToken->getToken();
    }

    /**
     * @param $user
     *
     * @param $type
     * @return Customer|mixed
     * @throws GraphQlAuthorizationException
     * @throws LocalizedException
     */
    private function prepareCustomer($user, $type)
    {
        $customer = $this->socialHelper->getCustomerByEmail($user['email']);

        if ($customer->getId()) {
            if ($type == "apple" && !isset($user['is_private_email'])) {
                if ($user['email'] != $customer->getEmail() && isset($user['email_verified'])) {
                    $customer->setEmail($user['email']);
                    $customer->save();
                }
            }
            $this->socialHelper->getCustomer($user['social_login_id'], $type);
        } else {
            try {
                $customer = $this->socialHelper->creatingAccount(
                    $user, sprintf(self::XML_PATH_ENABLE_CONFIRMATION_REQUIRED, $type)
                );
                $data = [
                    "id" => $user["social_login_id"],
                    "customerId" => $customer->getId(),
                    "type" => $type,
                    "email" => $user["email"],
                    "exist_email" => $user["exist_email"]
                ];
                $this->socialHelper->createSocialAccount($data);
            } catch (Exception $e) {
                throw new GraphQlAuthorizationException(__('Email is Null, Please enter email in your %1 profile',
                    $e->getMessage()));
            }
        }
        return $customer;
    }

    /**
     * @param $userData
     * @param $customerId
     * @return bool
     */
    public function updateSocialCustomer($userData, $customerId)
    {
        $socialData = [
            "id" => $userData["id"],
            "customerId" => $customerId,
            "type" => $userData['type'],
            "email" => $userData["email"],
            "exist_email" => $userData["exist_email"]
        ];
        try {
            if ($this->getSocialUser($socialData['email'], $socialData['customerId'], $socialData['type'])) {
                throw new GraphQlAuthorizationException(__('This social network has been linked'));
            }
            $this->socialHelper->createSocialAccount($socialData);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    private function getSocialUser($email, $customerId, $type)
    {
        $connection = $this->resourceConnection->getConnection();
        $socialTable = $connection->getTableName('magenest_social_login_account');
        $sql = $connection->select()->from(
            ['s' => $socialTable],
            [
                'email' => 's.social_email',
                'customer_id' => 's.customer_id',
                'type' => 's.social_login_type',
                'social_id' => 's.social_login_id'
            ]
        );
        $sql->where('s.social_email = ?', $email);
        $sql->where('s.customer_id = ?', $customerId);
        $sql->where('s.social_login_type = ?', $type);
        return $connection->fetchAll($sql);
    }

}
