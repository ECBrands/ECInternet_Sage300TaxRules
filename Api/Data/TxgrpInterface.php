<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Api\Data;

interface TxgrpInterface
{
    const COLUMN_ID          = 'entity_id';

    const COLUMN_STORE_ID    = 'store_id';

    const COLUMN_CREATED_AT  = 'created_at';

    const COLUMN_UPDATED_AT  = 'updated_at';

    const COLUMN_GROUPID     = 'GROUPID';

    const COLUMN_TTYPE       = 'TTYPE';

    const COLUMN_AUTHORITY1  = 'AUTHORITY1';

    const COLUMN_AUTHORITY2  = 'AUTHORITY2';

    const COLUMN_AUTHORITY3  = 'AUTHORITY3';

    const COLUMN_AUTHORITY4  = 'AUTHORITY4';

    const COLUMN_AUTHORITY5  = 'AUTHORITY5';

    const COLUMN_CALCMETHOD  = 'CALCMETHOD';

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
     * @return mixed
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
     * @return string
     */
    public function getTaxAuthority1();

    /**
     * @param string $taxAuthority1
     *
     * @return void
     */
    public function setTaxAuthority1(string $taxAuthority1);

    /**
     * @return string
     */
    public function getTaxAuthority2();

    /**
     * @param string $taxAuthority2
     *
     * @return void
     */
    public function setTaxAuthority2(string $taxAuthority2);

    /**
     * @return string
     */
    public function getTaxAuthority3();

    /**
     * @param string $taxAuthority3
     *
     * @return void
     */
    public function setTaxAuthority3(string $taxAuthority3);

    /**
     * @return string
     */
    public function getTaxAuthority4();

    /**
     * @param string $taxAuthority4
     *
     * @return void
     */
    public function setTaxAuthority4(string $taxAuthority4);

    /**
     * @return string
     */
    public function getTaxAuthority5();

    /**
     * @param string $taxAuthority5
     *
     * @return void
     */
    public function setTaxAuthority5(string $taxAuthority5);

    /**
     * @return int
     */
    public function getTaxCalculationMethod();

    /**
     * @param int $taxCalculationMethod
     *
     * @return void
     */
    public function setTaxCalculationMethod(int $taxCalculationMethod);
}
