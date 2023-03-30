<?php

namespace AHT\Route\Plugin\Model;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Api\CategoryRepositoryInterface;
class PrefixProductPlugin
{
    protected $request;
    private $categoryRepository;


    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
    ) {
        $this->request = $request;
        $this->categoryRepository = $categoryRepository;
    }

    /**
        return for categoryName_productName
     */
    public function afterGetName(Product $subject, $result): string
    {
        if ($this->request->getFullActionName() == 'catalog_category_view') {
//            $result = 'AHT_' . $result;
            $id = $this->request->getParam('id');
            $category = $this->categoryRepository->get($id);
            $categoryName = $category->getName();
            $result = $categoryName.'_'.$result;
            }
        return $result;
    }

}

