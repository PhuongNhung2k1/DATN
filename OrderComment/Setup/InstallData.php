<?php

namespace AHT\OrderComment\Setup;

use AHT\OrderComment\Model\Data\OrderComment;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;

use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @var \Magento\Sales\Setup\SalesSetupFactory
     */
    protected $salesSetupFactory;

    /**
     * @var \Magento\Quote\Setup\QuoteSetupFactory
     */
    protected $quoteSetupFactory;

    /**
     * InstallData constructor.
     * @param \Magento\Sales\Setup\SalesSetupFactory $salesSetupFactory
     * @param \Magento\Quote\Setup\QuoteSetupFactory $quoteSetupFactory
     */
    public function __construct(
        \Magento\Sales\Setup\SalesSetupFactory $salesSetupFactory,
        \Magento\Quote\Setup\QuoteSetupFactory $quoteSetupFactory
    ) {
        $this->salesSetupFactory = $salesSetupFactory;
        $this->quoteSetupFactory = $quoteSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /** @var \Magento\Quote\Setup\QuoteSetup $quoteInstaller
         * create data in quote
         */
        $quoteInstaller = $this->quoteSetupFactory->create(['resourceName' => 'quote_setup', 'setup' => $setup]);

        /** @var \Magento\Sales\Setup\SalesSetup $salesInstaller */
        $salesInstaller = $this->salesSetupFactory->create(['resourceName' => 'sales_setup', 'setup' => $setup]);
        // add field name is aht_order_comment in quote

        $quoteInstaller->addAttribute(
            'quote',
            OrderComment::COMMENT_FIELD_NAME,
            ['type' => Table::TYPE_TEXT, 'length' => '64k', 'nullable' => true]
        );

        $salesInstaller->addAttribute(
            'order',
            OrderComment::COMMENT_FIELD_NAME,
            ['type' => Table::TYPE_TEXT, 'length' => '64k', 'nullable' => true, 'grid' => true]
        );

        $setup->endSetup();
    }
}
