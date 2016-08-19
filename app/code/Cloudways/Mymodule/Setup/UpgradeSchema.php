<?php

namespace Cloudways\Mymodule\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.1') < 0) {

        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();
        //cart table
        $connection->addColumn(
                $installer->getTable('quote_item'),
                'remarks',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Remarks'
                ]
            );
        //Order address table
        $connection->addColumn(
                $installer->getTable('sales_order'),
                'remarks',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Remarks'

                ]
            );
        $installer->endSetup(); }
    }
}