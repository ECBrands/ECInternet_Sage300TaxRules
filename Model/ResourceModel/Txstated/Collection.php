<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Model\ResourceModel\Txstated;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected $_eventPrefix = 'ecinternet_sage300taxrules_txstated_collection';

    protected $_eventObject = 'txstated_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'ECInternet\Sage300TaxRules\Model\Data\Txstated',
            'ECInternet\Sage300TaxRules\Model\ResourceModel\Txstated'
        );
    }
}
