<?php


namespace Ionah\SocialLoginGraphQl\Model\Google;


use Ionah\SocialLoginGraphQl\Model\AbstractClient;

class Client extends AbstractClient
{
    protected $oauth2_service_uri = 'https://www.googleapis.com/oauth2/v2';

    public function getUserInfo($accessToken)
    {
        $endpoint = '/userinfo';
        $user = $this->api($endpoint, $accessToken);
        return [
            'id' => $user['id'],
            'email' => $user['email'] ?: $user['id'] . '@gmail.com',
            'lastname' => $user['family_name'] ?: (array_shift($user['family_name']) ?: $user['id']),
            'firstname' => $user['given_name'] ?: (array_shift($user['given_name']) ?: $user['id']),
            'identifier' => $user['id'],
        ];
    }
}
