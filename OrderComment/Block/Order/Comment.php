<?php

namespace AHT\OrderComment\Block\Order;

use AHT\OrderComment\Model\Data\OrderComment;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Sales\Model\Order;

class Comment extends \Magento\Framework\View\Element\Template
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    protected $_template = 1;

    /**
     * @param TemplateContext $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        TemplateContext $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->_isScopePrivate = true;

        parent::__construct($context, $data);
    }

    /**
     * @return Order
     */
    public function getOrder() : Order
    {
        return $this->coreRegistry->registry('current_order');
    }

    /**
     * @return string
     */
    public function getOrderComment(): string
    {
        return trim((string) $this->getOrder()->getData(OrderComment::COMMENT_FIELD_NAME));
    }

    public function hasOrderComment() : bool
    {
        return strlen($this->getOrderComment()) > 0;
    }

    public function getOrderCommentHtml() : string
    {
        return nl2br($this->escapeHtml($this->getOrderComment()));
    }
}
