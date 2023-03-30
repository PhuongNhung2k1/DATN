<?php
namespace AHT\OrderComment\Model\Data;

use AHT\OrderComment\Api\Data\OrderCommentInterface;
use Magento\Framework\Api\AbstractSimpleObject;

class OrderComment extends AbstractSimpleObject implements OrderCommentInterface
{
    const COMMENT_FIELD_NAME = 'aht_order_comment';

    /**
     * @return string|null
     */
    public function getComment()
    {
        return $this->_get(static::COMMENT_FIELD_NAME);
    }

    /**
     * @param string $comment
     * @return $this
     */
    public function setComment($comment)
    {
        return $this->setData(static::COMMENT_FIELD_NAME, $comment);
    }
}
