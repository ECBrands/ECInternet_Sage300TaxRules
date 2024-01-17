<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Setup\Patch\Data;

use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddTaxAttributesToCustomerAddress implements DataPatchInterface
{
    /**
     * @var \Magento\Eav\Model\Config
     */
    private $_eavConfig;

    /**
     * @var \Magento\Eav\Setup\EavSetupFactory
     */
    private $_eavSetupFactory;

    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $_moduleDataSetup;

    public function __construct(
        Config $eavConfig,
        EavSetupFactory $eavSetupFactory,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->_eavConfig       = $eavConfig;
        $this->_eavSetupFactory = $eavSetupFactory;
        $this->_moduleDataSetup = $moduleDataSetup;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply()
    {
        $this->_moduleDataSetup->getConnection()->startSetup();

        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->_eavSetupFactory->create();

        $eavSetup->addAttribute('customer_address', 'codetaxgrp', [
            'type' => 'varchar',
            'input' => 'text',
            'label' => 'Tax Group Code',
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'system' => false,
            'group' => 'General',
            'global' => true,
            'visible_on_front' => false
        ]);

        $customAttribute = $this->_eavConfig->getAttribute('customer_address', 'codetaxgrp');
        $customAttribute->setData('used_in_forms', [
            'adminhtml_customer_address'
        ]);

        ////////////

        $eavSetup->addAttribute('customer_address', 'taxstts1', [
            'type' => 'varchar',
            'input' => 'text',
            'label' => 'Tax Class Code 1',
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'system' => false,
            'group' => 'General',
            'global' => true,
            'visible_on_front' => false
        ]);

        $customAttribute = $this->_eavConfig->getAttribute('customer_address', 'taxstts1');
        $customAttribute->setData('used_in_forms', [
            'adminhtml_customer_address'
        ]);

        $this->_moduleDataSetup->getConnection()->endSetup();
    }
}
