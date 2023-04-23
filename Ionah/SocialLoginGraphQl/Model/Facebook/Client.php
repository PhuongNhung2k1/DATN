<?php


namespace Ionah\SocialLoginGraphQl\Model\Facebook;

use Facebook\FacebookClient;
use Ionah\SocialLoginGraphQl\Model\AbstractClient;

class Client extends AbstractClient
{
    protected $userInfo = [
        'id',
        'name',
        'email',
        'first_name',
        'last_name'
    ];
    protected $oauth2_service_uri = FacebookClient::BASE_GRAPH_URL;

    public function getUserInfo($accessToken)
    {
        $endpoint = '/me?fields=' . implode(',', $this->userInfo);
        $fbUser = $this->api($endpoint, $accessToken);
        return [
            'id' => $fbUser['id'],
            'email' => $fbUser['email'] ?: $fbUser['id'] . '@fbionah.com',
            'lastname' => $fbUser['last_name'] ?: (array_shift($fbUser['last_name']) ?: $fbUser['id']),
            'firstname' => $fbUser['first_name'] ?: (array_shift($fbUser['first_name']) ?: $fbUser['id']),
            'identifier' => $fbUser['id'],
        ];
    }
}
