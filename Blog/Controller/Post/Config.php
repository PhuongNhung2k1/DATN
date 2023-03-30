<?php

namespace AHT\Blog\Controller\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config extends Action
{

    const ENABLED = "setting/post/enabled";
    const NAME = "setting/post/name";
    const COUNTRY = "setting/post/country";
    const STATUS = "setting/post/status";

    protected $scopeConfig;

    public function __construct(
        Context $context,
        ScopeConfigInterface  $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    public function execute()
    {
        $enabled = $this->scopeConfig->getValue(self::ENABLED);
        $name = $this->scopeConfig->getValue(self::NAME, ScopeInterface::SCOPE_STORE);
        $country = $this->scopeConfig->getValue(self::COUNTRY, ScopeInterface::SCOPE_STORE);
        $status = $this->scopeConfig->getValue(self::STATUS, ScopeInterface::SCOPE_STORE);
        echo 'Enabled: '.$enabled.'<br>';
        echo 'Name: '.$name.'<br>';
        echo 'Country: '.$country.'<br>';
        echo 'Status: '.$status;
    }
}
