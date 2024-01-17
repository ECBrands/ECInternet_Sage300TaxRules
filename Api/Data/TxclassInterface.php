<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Api\Data;

interface TxclassInterface
{
    public const COLUMN_ID              = 'entity_id';

    public const COLUMN_STORE_ID        = 'store_id';

    public const COLUMN_CREATED_AT      = 'created_at';

    public const COLUMN_UPDATED_AT      = 'updated_at';

    public const COLUMN_AUTHORITY       = 'AUTHORITY';

    public const COLUMN_CLASSTYPE       = 'CLASSTYPE';

    public const COLUMN_CLASSAXIS       = 'CLASSAXIS';

    public const COLUMN_CLASS           = 'CLASS';

    public const COLUMN_AUDTDATE        = 'AUDTDATE';

    public const COLUMN_AUDTTIME        = 'AUDTTIME';

    public const COLUMN_AUDTUSER        = 'AUDTUSER';

    public const COLUMN_AUDTORG         = 'AUDTORG';

    public const COLUMN_EXEMPT          = 'EXEMPT';

    public const TRANSACTION_TYPE_SALES = 1;

    public const CLASS_TYPE_CUSTOMERS   = 1;

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
     * @return mixed
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
    public function getClassType();

    /**
     * @param int $classType
     *
     * @return void
     */
    public function setClassType(int $classType);

    /**
     * @return mixed
     */
    public function getClass();

    /**
     * @param int $class
     *
     * @return void
     */
    public function setClass(int $class);

    /**
     * @return mixed
     */
    public function getExempt();

    /**
     * @param int $exempt
     *
     * @return void
     */
    public function setExempt(int $exempt);
}
