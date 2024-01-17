<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Model;

use ECInternet\Sage300TaxRules\Api\TxgrpRepositoryInterface;
use ECInternet\Sage300TaxRules\Model\Data\Txgrp;
use ECInternet\Sage300TaxRules\Model\ResourceModel\Txgrp\CollectionFactory as TxgrpCollectionFactory;

class TxgrpRepository implements TxgrpRepositoryInterface
{
    /**
     * @var \ECInternet\Sage300TaxRules\Model\ResourceModel\Txclass\CollectionFactory
     */
    private $_txgrpCollectionFactory;

    /**
     * @param \ECInternet\Sage300TaxRules\Model\ResourceModel\Txgrp\CollectionFactory $txgrpCollectionFactory
     */
    public function __construct(
        TxgrpCollectionFactory $txgrpCollectionFactory
    ) {
        $this->_txgrpCollectionFactory = $txgrpCollectionFactory;
    }

    public function get(string $taxGroup, int $transactionType)
    {
        $collection = $this->_txgrpCollectionFactory->create()
            ->addFieldToFilter(Txgrp::COLUMN_GROUPID, ['eq' => $taxGroup])
            ->addFieldToFilter(Txgrp::COLUMN_TTYPE, ['eq' => $transactionType]);

        $collectionCount = $collection->getSize();
        if ($collectionCount === 1) {
            $txgrp = $collection->getFirstItem();
            if ($txgrp instanceof Txgrp) {
                return $txgrp;
            }
        }

        return null;
    }
}
