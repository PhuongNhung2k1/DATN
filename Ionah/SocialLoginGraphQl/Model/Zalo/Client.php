<?php


namespace Ionah\SocialLoginGraphQl\Model\Zalo;

use Zalo\ZaloEndPoint;

use Ionah\SocialLoginGraphQl\Model\AbstractClient;

class Client extends AbstractClient
{
    protected $oauth2_service_uri = ZaloEndPoint::API_GRAPH_ME;

    public function getUserInfo($accessToken)
    {
        $user = $this->api('?fields=id,name,email', $accessToken);
        return [
            'id' => $user['id'],
            'email' => isset($user['email']) ? $user['email'] : $user['id'] . '@zaloionah.com',
            'lastname' => $this->splitName($user['name'])['last_name'],
            'firstname' => $this->splitName($user['name'])['first_name'],
            'identifier' => $user['id'],
        ];
    }

    /**
     * @param $name
     *
     * @return array
     */
    public function splitName($name)
    {
        $name = explode(' ', trim($name), 2);
        if (count($name) > 1) {
            $firstName = $name[0];
            $lastName = $name[1];
        } else {
            $firstName = $name[0];
            $lastName = $name[0];
        }
        return ['first_name' => $firstName, 'last_name' => $lastName];
    }
}
