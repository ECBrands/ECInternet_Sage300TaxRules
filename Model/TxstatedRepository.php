<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Model;

use ECInternet\Sage300TaxRules\Api\TxstatedRepositoryInterface;
use ECInternet\Sage300TaxRules\Model\Data\Txstated;
use ECInternet\Sage300TaxRules\Model\ResourceModel\Txstated\CollectionFactory as TxstatedCollectionFactory;

class TxstatedRepository implements TxstatedRepositoryInterface
{
    /**
     * @var \ECInternet\Sage300TaxRules\Model\ResourceModel\Txstated\CollectionFactory
     */
    private $_txstatedCollectionFactory;

    /**
     * TxstatedRepository constructor.
     *
     * @param \ECInternet\Sage300TaxRules\Model\ResourceModel\Txstated\CollectionFactory $txstatedCollectionFactory
     */
    public function __construct(
        TxstatedCollectionFactory $txstatedCollectionFactory
    ) {
        $this->_txstatedCollectionFactory = $txstatedCollectionFactory;
    }

    public function get(string $taxGroup, int $transactionType = 1, int $version = 1, int $taxAuthorityLineNumber = 1)
    {
        $collection = $this->_txstatedCollectionFactory->create()
            ->addFieldToFilter(Txstated::COLUMN_GROUPID, ['eq' => $taxGroup])
            ->addFieldToFilter(Txstated::COLUMN_TTYPE, ['eq' => $transactionType])
            ->addFieldToFilter(Txstated::COLUMN_VERSION, ['eq' => $version])
            ->addFieldToFilter(Txstated::COLUMN_TXAUTHNUM, ['eq' => $taxAuthorityLineNumber])
            ->setOrder(Txstated::COLUMN_VERSION, 'DESC');

        $collectionCount = $collection->getSize();
        if ($collectionCount >= 1) {
            $txstated = $collection->getFirstItem();
            if ($txstated instanceof Txstated) {
                return $txstated;
            }
        }

        return null;
    }

    public function getByGroupAndAuthority(string $taxGroup, string $taxAuthority)
    {
        $collection = $this->_txstatedCollectionFactory->create()
            ->addFieldToFilter(Txstated::COLUMN_GROUPID, ['eq' => $taxGroup])
            ->addFieldToFilter(Txstated::COLUMN_TTYPE, ['eq' => Txstated::TRANSACTION_TYPE_SALES])
            //->addFieldToFilter(Txstated::COLUMN_TXAUTHNUM, ['eq' => 1])
            ->addFieldToFilter(Txstated::COLUMN_AUTHORITY, ['eq' => $taxAuthority])
            ->setOrder(Txstated::COLUMN_VERSION, 'DESC');

        $collectionCount = $collection->getSize();
        if ($collectionCount >= 1) {
            $txstated = $collection->getFirstItem();
            if ($txstated instanceof Txstated) {
                return $txstated;
            }
        }

        return null;
    }
}
