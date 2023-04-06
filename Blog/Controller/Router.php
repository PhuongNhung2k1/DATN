<?php

namespace AHT\Blog\Controller;

use Magento\Framework\App\Router\Base as BaseRouter;

class Router extends BaseRouter
{
    // I remove all the variables here for simplicity so that you can read the code
    /**
     * @param \Magento\Framework\App\Router\ActionList $actionList
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Magento\Framework\App\DefaultPathInterface $defaultPath
     * @param \Magento\Framework\App\ResponseFactory $responseFactory
     * @param \Magento\Framework\App\Route\ConfigInterface $routeConfig
     * @param \Magento\Framework\UrlInterface $url
     * @param string $routerId
     * @param \Magento\Framework\Code\NameBuilder $nameBuilder
     * @param \Magento\Framework\App\Router\PathConfigInterface $pathConfig
     *
     * @throws \InvalidArgumentException
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(
        \Magento\Framework\App\Router\ActionList          $actionList,
        \Magento\Framework\App\ActionFactory              $actionFactory,
        \Magento\Framework\App\DefaultPathInterface       $defaultPath,
        \Magento\Framework\App\ResponseFactory            $responseFactory,
        \Magento\Framework\App\Route\ConfigInterface      $routeConfig,
        \Magento\Framework\UrlInterface                   $url,
        \Magento\Framework\Code\NameBuilder               $nameBuilder,
        \Magento\Framework\App\Router\PathConfigInterface $pathConfig
    )
    {
        $this->actionList = $actionList;
        $this->actionFactory = $actionFactory;
        $this->_responseFactory = $responseFactory;
        $this->_defaultPath = $defaultPath;
        $this->_routeConfig = $routeConfig;
        $this->_url = $url;
        $this->nameBuilder = $nameBuilder;
        $this->pathConfig = $pathConfig;
    }

    /**
     * Match provided request and if matched - return corresponding controller
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return \Magento\Framework\App\ActionInterface|null
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $urlKey = trim($request->getPathInfo(), '/');
//        $test = $request->getPathInfo()->requestUri();
//        $changUrl = str_replace('/', '-', $test);
        $urlKey = explode('/', trim($urlKey));
        $result = '';
        for ($i = 2; $i < count($urlKey); $i++) {
            $result .= $urlKey[$i] . '-';
        }
//        echo $result. 'html';

//        var_dump($urlKey);
//        var_dump($changUrl);
//        die();
    }

    public function execute(\Magento\Framework\App\RequestInterface $request){
        return $request->getPathInfo();
    }
}
