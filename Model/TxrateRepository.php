<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Model;

use ECInternet\Sage300TaxRules\Api\TxrateRepositoryInterface;
use ECInternet\Sage300TaxRules\Model\Data\Txrate;
use ECInternet\Sage300TaxRules\Model\ResourceModel\Txrate\CollectionFactory as TxrateCollectionFactory;

class TxrateRepository implements TxrateRepositoryInterface
{
    /**
     * @var \ECInternet\Sage300TaxRules\Model\ResourceModel\Txrate\CollectionFactory
     */
    private $_txrateCollectionFactory;

    /**
     * @param \ECInternet\Sage300TaxRules\Model\ResourceModel\Txrate\CollectionFactory $txrateCollectionFactory
     */
    public function __construct(
        TxrateCollectionFactory $txrateCollectionFactory
    ) {
        $this->_txrateCollectionFactory = $txrateCollectionFactory;
    }

    public function get(string $taxAuthority, int $transactionType, int $buyerClass)
    {
        $collection = $this->_txrateCollectionFactory->create()
            ->addFieldToFilter(Txrate::COLUMN_AUTHORITY, ['eq' => $taxAuthority])
            ->addFieldToFilter(Txrate::COLUMN_TTYPE, ['eq' => $transactionType])
            ->addFieldToFilter(Txrate::COLUMN_BUYERCLASS, ['eq' => $buyerClass]);

        $collectionCount = $collection->getSize();
        if ($collectionCount === 1) {
            $txrate = $collection->getFirstItem();
            if ($txrate instanceof Txrate) {
                return $txrate;
            }
        }

        return null;
    }
}
