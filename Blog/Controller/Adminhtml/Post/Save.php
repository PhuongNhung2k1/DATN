<?php

namespace AHT\Blog\Controller\Adminhtml\Post;

//use AHT\Blog\Api\PostRepositoryInterface;
use AHT\Blog\Model\ImageUploader;
use AHT\Blog\Model\PostFactory;
use AHT\Blog\Model\ResourceModel\Post;
use Exception;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Save extends Action
{
    /**
     * @var PostFactory
     */
    private $postFactory;
    private $postResourceModel;
    private $imageUploader;
//    private PostRepositoryInterface $postRepository;
    public function __construct(
        Context $context,
        PostFactory $postFactory,
        Post $postResourceModel,
        ImageUploader $imageUploader,
//        PostRepositoryInterface $postRepository,
    ) {
        $this->postFactory = $postFactory;
        $this->postResourceModel = $postResourceModel;
        $this->imageUploader = $imageUploader;
//        $this->postRepository = $postRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $id = !empty($data['entity_id']) ? $data['entity_id'] : null;
        $post = $this->postFactory->create();
        if ($id) {
//            $this->postRepository->get($id);
            $this->postResourceModel->load($post, $id);
        }
        try {
            /*
             * After disable for delete image and image path in database,
             */
            if (isset($data['image'][0]['image_path'])) {
                $data['image'] = $data['image'][0]['image_path'];
                $post->getData($data['image']);
                $imageName = $data['image'];
            } else {
                $imageName = '';
            }
            $data['image'] = $imageName;
//            $data['image'] = $data['image'][0]['image_path'] ?? '';
            $this->prepareCategories($data);
            $post->setData($data);
            $this->postResourceModel->save($post);
//            $this->postRepository->save($post);
            $this->messageManager->addSuccessMessage(__('You saved the post.'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        return $this->resultRedirectFactory->create()->setPath('blog/post/index');
    }
    protected function prepareCategories(&$data)
    {
        if (isset($data['category_id'])) {
            $data['category_id'] = implode(',', $data['category_id']);
        }
    }
}
