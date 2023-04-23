<?php

namespace Ionah\SocialLoginGraphQl\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Ionah\Base\Model\Image as BaseImageModel;
use Magento\Framework\View\Asset\Repository;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;

class Data extends AbstractHelper
{
    const SOCIAL_OPTIONS = [
        'facebook' => 'Facebook',
        'google' => 'Google',
        'zalo' => 'Zalo',
    ];

    /**
     * @var Repository
     */
    private $assetRepo;

    /**
     * @var BaseImageModel
     */
    private $baseImageModel;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        Repository $assetRepo,
        BaseImageModel $baseImageModel,
        StoreManagerInterface $storeManager,
        Context $context
    ) {
        $this->assetRepo = $assetRepo;
        $this->baseImageModel = $baseImageModel;
        $this->storeManager  = $storeManager;
        parent::__construct($context);
    }

    /**
     * @param $type
     * @return string
     */
    public function getSocialIcon($type)
    {
        $iconName = $type . '.png';
        $iconUrl = $this->getMediaUrl() . 'social/icons/' . $iconName;
        return $iconUrl;
        //return $this->baseImageModel->getImageUrlByFileId($this->_getModuleName(), 'images/icons/' . $iconName);
    }

    /**
     * @param $type
     * @return string
     */
    public function getSocialLabel($type)
    {
        return self::SOCIAL_OPTIONS[$type];
    }

    /**
     * Get base media url
     *
     * @return string
     */
    private function getMediaUrl()
    {
        $currentStore = $this->storeManager->getStore();
        return $currentStore->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
    }
}
