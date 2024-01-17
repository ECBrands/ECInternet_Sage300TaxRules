<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Model;

use ECInternet\Sage300TaxRules\Api\TxclassRepositoryInterface;
use ECInternet\Sage300TaxRules\Model\Data\Txclass;
use ECInternet\Sage300TaxRules\Model\ResourceModel\Txclass\CollectionFactory as TxclassCollectionFactory;

class TxclassRepository implements TxclassRepositoryInterface
{
    /**
     * @var \ECInternet\Sage300TaxRules\Model\ResourceModel\Txclass\CollectionFactory
     */
    private $_txclassCollectionFactory;

    /**
     * @param \ECInternet\Sage300TaxRules\Model\ResourceModel\Txclass\CollectionFactory $txclassCollectionFactory
     */
    public function __construct(
        TxclassCollectionFactory $txclassCollectionFactory
    ) {
        $this->_txclassCollectionFactory = $txclassCollectionFactory;
    }

    public function get(string $taxAuthority, int $transactionType, int $classType, int $class)
    {
        $collection = $this->_txclassCollectionFactory->create()
            ->addFieldToFilter(Txclass::COLUMN_AUTHORITY, ['eq' => $taxAuthority])
            ->addFieldToFilter(Txclass::COLUMN_CLASSTYPE, ['eq' => $transactionType])
            ->addFieldToFilter(Txclass::COLUMN_CLASSAXIS, ['eq' => $classType])
            ->addFieldToFilter(Txclass::COLUMN_CLASS, ['eq' => $class]);

        $collectionCount = $collection->getSize();
        if ($collectionCount === 1) {
            $txclass = $collection->getFirstItem();
            if ($txclass instanceof Txclass) {
                return $txclass;
            }
        }

        return null;
    }

    public function getByAuthorityAndClass(string $taxAuthority, int $class)
    {
        return $this->get($taxAuthority, Txclass::TRANSACTION_TYPE_SALES, Txclass::CLASS_TYPE_CUSTOMERS, $class);
    }
}
