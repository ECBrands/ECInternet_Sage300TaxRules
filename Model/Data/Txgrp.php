<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Model\Data;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime;
use ECInternet\Sage300TaxRules\Api\Data\TxgrpInterface;

/**
 * Txgrp Model
 */
class Txgrp extends AbstractModel implements IdentityInterface, TxgrpInterface
{
    const CACHE_TAG = 'ecinternet_sage300taxrules_txgrp';

    protected $_cacheTag    = 'ecinternet_sage300taxrules_txgrp';

    protected $_eventPrefix = 'ecinternet_sage300taxrules_txgrp';

    protected $_eventObject = 'txgrp';

    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    private $_dateTime;

    /**
     * @param \Magento\Framework\Model\Context                             $context
     * @param \Magento\Framework\Registry                                  $registry
     * @param \Magento\Framework\Stdlib\DateTime                           $dateTime
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null           $resourceCollection
     * @param array                                                        $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        DateTime $dateTime,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_dateTime = $dateTime;

        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ECInternet\Sage300TaxRules\Model\ResourceModel\Txgrp');
    }

    /**
     * @inheritDoc
     */
    public function beforeSave()
    {
        // Always update (we can use this to verify syncs are running)
        $this->setUpdatedAt($this->_dateTime->formatDate(true));

        return parent::beforeSave();
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getId()
    {
        return $this->getData(self::COLUMN_ID);
    }

    public function getStoreId()
    {
        return (int)$this->getData(self::COLUMN_STORE_ID);
    }

    public function setStoreId(int $storeId)
    {
        $this->setData(self::COLUMN_STORE_ID, $storeId);
    }

    public function getCreatedAt()
    {
        return (string)$this->getData(self::COLUMN_CREATED_AT);
    }

    public function setCreatedAt(string $createdAt)
    {
        $this->setData(self::COLUMN_CREATED_AT, $createdAt);
    }

    public function getUpdatedAt()
    {
        return (string)$this->getData(self::COLUMN_UPDATED_AT);
    }

    public function setUpdatedAt(string $updatedAt)
    {
        $this->setData(self::COLUMN_UPDATED_AT, $updatedAt);
    }

    public function getTaxGroup()
    {
        return (string)$this->getData(self::COLUMN_GROUPID);
    }

    public function setTaxGroup(string $taxGroup)
    {
        $this->setData(self::COLUMN_GROUPID, $taxGroup);
    }

    public function getTransactionType()
    {
        return (int)$this->getData(self::COLUMN_TTYPE);
    }

    public function setTransactionType(int $transactionType)
    {
        $this->setData(self::COLUMN_TTYPE, $transactionType);
    }

    public function getTaxAuthority1()
    {
        return (string)$this->getData(self::COLUMN_AUTHORITY1);
    }

    public function setTaxAuthority1(string $taxAuthority1)
    {
        $this->setData(self::COLUMN_AUTHORITY1, $taxAuthority1);
    }

    public function getTaxAuthority2()
    {
        return (string)$this->getData(self::COLUMN_AUTHORITY2);
    }

    public function setTaxAuthority2(string $taxAuthority2)
    {
        $this->setData(self::COLUMN_AUTHORITY2, $taxAuthority2);
    }

    public function getTaxAuthority3()
    {
        return (string)$this->getData(self::COLUMN_AUTHORITY3);
    }

    public function setTaxAuthority3(string $taxAuthority3)
    {
        $this->setData(self::COLUMN_AUTHORITY3, $taxAuthority3);
    }

    public function getTaxAuthority4()
    {
        return (string)$this->getData(self::COLUMN_AUTHORITY4);
    }

    public function setTaxAuthority4(string $taxAuthority4)
    {
        $this->setData(self::COLUMN_AUTHORITY4, $taxAuthority4);
    }

    public function getTaxAuthority5()
    {
        return (string)$this->getData(self::COLUMN_AUTHORITY5);
    }

    public function setTaxAuthority5(string $taxAuthority5)
    {
        $this->setData(self::COLUMN_AUTHORITY5, $taxAuthority5);
    }

    public function getTaxCalculationMethod()
    {
        return (int)$this->getData(self::COLUMN_CALCMETHOD);
    }

    public function setTaxCalculationMethod($taxCalculationMethod)
    {
        $this->setData(self::COLUMN_CALCMETHOD, $taxCalculationMethod);
    }
}
