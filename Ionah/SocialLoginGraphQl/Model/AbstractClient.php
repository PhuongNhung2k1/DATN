<?php

namespace Ionah\SocialLoginGraphQl\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\ZendClientFactory;

/**
 * Class AbstractClient
 * @package Magenest\SocialLogin\Model
 */
abstract class AbstractClient
{
    /**
     * @var ZendClientFactory
     */
    private $_httpClientFactory;

    /**
     * @var string
     */
    protected $oauth2_service_uri;

    /**
     * AbstractClient constructor.
     * @param ZendClientFactory $httpClientFactory
     */
    public function __construct(
        ZendClientFactory $httpClientFactory
    ) {
        $this->_httpClientFactory = $httpClientFactory;
    }


    /**
     * @param $endpoint
     * @param $accessToken
     * @param string $method
     * @param array $params
     * @return mixed
     * @throws LocalizedException
     * @throws \Zend_Http_Client_Exception
     */
    public function api($endpoint, $accessToken, $method = 'GET', $params = [])
    {
        $url = $this->oauth2_service_uri . $endpoint;

        $method = strtoupper($method);
        $params = array_merge([
            'access_token' => $accessToken
        ], $params);

        return $this->processResponse($this->sendRequest($url, $method, $params));
    }

    /**
     * @param $url
     * @param string $method
     * @param array $params
     * @param array $headers
     * @return mixed
     * @throws LocalizedException
     * @throws \Zend_Http_Client_Exception
     */
    protected function _httpRequest($url, $method = 'GET', $params = [], $headers = [])
    {
        return $this->processResponse($this->sendRequest($url, $method, $params, $headers));
    }

    /**
     * @param $url
     * @param string $method
     * @param array $params
     * @param array $headers
     * @return \Zend_Http_Response
     * @throws LocalizedException
     * @throws \Zend_Http_Client_Exception
     */
    protected function sendRequest($url, $method = 'GET', $params = [], $headers = [])
    {
        $client = $this->_httpClientFactory->create();
        $headers = array_merge([
            'Accept' => 'application/json'
        ], $headers);
        $client->setHeaders($headers);
        $client->setUri($url);
        switch ($method) {
            case 'GET':
            case 'DELETE':
                $client->setParameterGet($params);
                break;
            case 'POST':
                $client->setParameterPost($params);
                break;
            default:
                throw new LocalizedException(
                    __('Required HTTP method is not supported.')
                );
        }
        $response = $client->request($method);

        if ($response->isError()) {
            $status = $response->getStatus();
            if (($status == 400 || $status == 401)) {
                $decodedResponse = $this->processResponse($response);
                if (isset($decodedResponse['error']['message'])) {
                    $message = $decodedResponse['error']['message'];
                } else {
                    $message = __('Unspecified OAuth error occurred.');
                }
                throw new LocalizedException(__($message));
            } else {
                $message = sprintf(
                    __('HTTP error %d occurred while issuing request.'),
                    $status
                );
                throw new LocalizedException(__($message));
            }
        }

        return $response;
    }

    /**
     * @param \Zend_Http_Response $response
     * @return mixed
     */
    protected function processResponse($response)
    {
        $decodedResponse = json_decode($response->getBody(), true);
        if (empty($decodedResponse)) {
            $parsed_response = [];
            parse_str($response->getBody(), $parsed_response);
            $decodedResponse = json_decode(json_encode($parsed_response), true);
        }
        return $decodedResponse;
    }
}
