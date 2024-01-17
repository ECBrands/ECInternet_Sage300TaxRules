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
use ECInternet\Sage300TaxRules\Api\Data\TxclassInterface;

/**
 * Txclass Model
 */
class Txclass extends AbstractModel implements IdentityInterface, TxclassInterface
{
    const CACHE_TAG = 'ecinternet_sage300taxrules_txclass';

    protected $_cacheTag    = 'ecinternet_sage300taxrules_txclass';

    protected $_eventPrefix = 'ecinternet_sage300taxrules_txclass';

    protected $_eventObject = 'txclass';

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
        $this->_init('ECInternet\Sage300TaxRules\Model\ResourceModel\Txclass');
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
        return $this->getData(self::COLUMN_UPDATED_AT);
    }

    public function setUpdatedAt(string $updatedAt)
    {
        $this->setData(self::COLUMN_UPDATED_AT, $updatedAt);
    }

    public function getTaxAuthority()
    {
        return (string)$this->getData(self::COLUMN_AUTHORITY);
    }

    public function setTaxAuthority(string $taxAuthority)
    {
        $this->setData(self::COLUMN_AUTHORITY, $taxAuthority);
    }

    public function getTransactionType()
    {
        return (int)$this->getData(self::COLUMN_CLASSTYPE);
    }

    public function setTransactionType(int $transactionType)
    {
        $this->setData(self::COLUMN_CLASSTYPE, $transactionType);
    }

    public function getClassType()
    {
        return (int)$this->getData(self::COLUMN_CLASSAXIS);
    }

    public function setClassType(int $classType)
    {
        $this->setData(self::COLUMN_CLASSAXIS, $classType);
    }

    public function getClass()
    {
        return (int)$this->getData(self::COLUMN_CLASS);
    }

    public function setClass(int $class)
    {
        $this->setData(self::COLUMN_CLASS, $class);
    }

    public function getExempt()
    {
        return (int)$this->getData(self::COLUMN_EXEMPT);
    }

    public function setExempt(int $exempt)
    {
        $this->setData(self::COLUMN_EXEMPT, $exempt);
    }
}
