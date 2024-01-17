<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public const CONFIG_PATH_ENABLED                  = 'sage300taxrules/taxgroupsettings/taxgroup';

    public const CONFIG_PATH_DEFAULT_TAX_GROUP        = 'sage300taxrules/taxgroupsettings/taxgroup';

    public const CONFIG_PATH_GOOGLE_API_KEY           = 'sage300taxrules/taxgroupsettings/googleapikey';

    public const ATTRIBUTE_CUSTOMER_ADDRESS_TAX_GROUP = 'codetaxgrp';

    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_ENABLED);
    }

    public function getDefaultTaxGroup()
    {
        return $this->scopeConfig->getValue(self::CONFIG_PATH_DEFAULT_TAX_GROUP);
    }
}
