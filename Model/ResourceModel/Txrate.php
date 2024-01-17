<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Txrate extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('ecinternet_sage300taxrules_txrate', 'entity_id');
    }
}
