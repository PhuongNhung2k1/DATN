<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AHT\Route\Api\Data;

interface PostInterface
{

    const POST = 'Post';
    const POST_ID = 'post_id';

    /**
     * Get post_id
     * @return string|null
     */
    public function getPostId();

    /**
     * Set post_id
     * @param string $postId
     * @return \AHT\Route\Post\Api\Data\PostInterface
     */
    public function setPostId($postId);


    /**
     * Get post_name
     * @return string|null
     */
    public function getPostName();

    /**
     * Set post_name
     * @param string $postName
     * @return \AHT\Route\Post\Api\Data\PostInterface
     */
    public function setPostName($postName);

    /**
     * Get post_Url
     * @return string|null
     */
    public function getPostUrl();

    /**
     * Set post_Url
     * @param string $postUrl
     * @return \AHT\Route\Post\Api\Data\PostInterface
     */
    public function setPostUrl($postUrl);

    /**
     * Get post_tag
     * @return string|null
     */
    public function getPostTags();

    /**
     * Set post_tag
     * @param string $postTags
     * @return \AHT\Route\Post\Api\Data\PostInterface
     */
    public function setPostTags($postTags);

    /**
     * Get post_status
     * @return string|null
     */
    public function getPostStatus();

    /**
     * Set post_status
     * @param string $postStatus
     * @return \AHT\Route\Post\Api\Data\PostInterface
     */
    public function setPostStatus($postStatus);

    /**
     * Get post_content
     * @return string|null
     */
    public function getPostContent();

    /**
     * Set post_content
     * @param string $postContent
     * @return \AHT\Route\Post\Api\Data\PostInterface
     */
    public function setPostContent($postContent);
}
