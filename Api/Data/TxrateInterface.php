<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Api\Data;

interface TxrateInterface
{
    const COLUMN_ID                  = 'entity_id';

    const COLUMN_STORE_ID            = 'store_id';

    const COLUMN_CREATED_AT          = 'created_at';

    const COLUMN_UPDATED_AT          = 'updated_at';

    const COLUMN_AUTHORITY           = 'AUTHORITY';

    const COLUMN_TTYPE               = 'TTYPE';

    const COLUMN_BUYERCLASS          = 'BUYERCLASS';

    const COLUMN_ITEMRATE1           = 'ITEMRATE1';

    const TRANSACTION_TYPE_SALES     = 1;

    const TRANSACTION_TYPE_PURCHASES = 2;

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return int
     */
    public function getStoreId();

    /**
     * @param int $storeId
     *
     * @return void
     */
    public function setStoreId(int $storeId);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     *
     * @return void
     */
    public function setCreatedAt(string $createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param string $updatedAt
     *
     * @return void
     */
    public function setUpdatedAt(string $updatedAt);

    /**
     * @return string
     */
    public function getTaxAuthority();

    /**
     * @param string $taxAuthority
     *
     * @return void
     */
    public function setTaxAuthority(string $taxAuthority);

    /**
     * @return int
     */
    public function getTransactionType();

    /**
     * @param int $transactionType
     *
     * @return void
     */
    public function setTransactionType(int $transactionType);

    /**
     * @return int
     */
    public function getBuyerClass();

    /**
     * @param int $buyerClass
     *
     * @return void
     */
    public function setBuyerClass(int $buyerClass);

    /**
     * @return float
     */
    public function getItemRate1();

    /**
     * @param float $itemRate1
     *
     * @return void
     */
    public function setItemRate1(float $itemRate1);
}
