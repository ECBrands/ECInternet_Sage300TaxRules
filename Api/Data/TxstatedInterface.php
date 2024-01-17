<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Api\Data;

interface TxstatedInterface
{
    const COLUMN_ID                  = 'entity_id';

    const COLUMN_STORE_ID            = 'store_id';

    const COLUMN_CREATED_AT          = 'created_at';

    const COLUMN_UPDATED_AT          = 'updated_at';

    const COLUMN_GROUPID             = 'GROUPID';

    const COLUMN_TTYPE               = 'TTYPE';

    const COLUMN_VERSION             = 'VERSION';

    const COLUMN_TXAUTHNUM           = 'TXAUTHNUM';

    const COLUMN_AUTHORITY           = 'AUTHORITY';

    const COLUMN_TXRATE0101          = 'TXRATE0101';

    const TRANSACTION_TYPE_SALES     = 1;

    const TRANSACTION_TYPE_PURCHASES = 2;

    const TAX_BASE_SELLING_PRICE     = 1;

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
    public function getTaxGroup();

    /**
     * @param string $taxGroup
     *
     * @return void
     */
    public function setTaxGroup(string $taxGroup);

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
    public function getVersion();

    /**
     * @param int $version
     *
     * @return void
     */
    public function setVersion(int $version);

    /**
     * @return int
     */
    public function getTaxAuthorityLineNumber();

    /**
     * @param int $taxAuthorityLineNumber
     *
     * @return void
     */
    public function setTaxAuthorityLineNumber(int $taxAuthorityLineNumber);

    /**
     * @return float
     */
    public function getTaxRate0101();

    /**
     * @param float $taxRate0101
     *
     * @return void
     */
    public function setTaxRate0101(float $taxRate0101);
}
