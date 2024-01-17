<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Model;

use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Quote\Api\Data\AddressInterface;
use ECInternet\Sage300TaxRules\Api\TxclassRepositoryInterface;
use ECInternet\Sage300TaxRules\Api\TxgrpRepositoryInterface;
use ECInternet\Sage300TaxRules\Api\TxrateRepositoryInterface;
use ECInternet\Sage300TaxRules\Api\TxstatedRepositoryInterface;
use ECInternet\Sage300TaxRules\Logger\Logger;
use ECInternet\Sage300TaxRules\Model\Data\Txrate;
use Exception;

class TaxCalculator
{
    /**
     * @var \Magento\Customer\Api\AddressRepositoryInterface
     */
    private $_addressRepository;

    /**
     * @var \ECInternet\Sage300TaxRules\Api\TxclassRepositoryInterface
     */
    private $_txclassRepository;

    /**
     * @var \ECInternet\Sage300TaxRules\Api\TxgrpRepositoryInterface
     */
    private $_txgrpRepository;

    /**
     * @var \ECInternet\Sage300TaxRules\Api\TxrateRepositoryInterface
     */
    private $_txrateRepository;

    /**
     * @var \ECInternet\Sage300TaxRules\Api\TxstatedRepositoryInterface
     */
    private $_txstatedRepository;

    /**
     * @var \ECInternet\Sage300TaxRules\Logger\Logger
     */
    private $_logger;

    /**
     * TaxCalculator constructor.
     *
     * @param \Magento\Customer\Api\AddressRepositoryInterface            $addressRepository
     * @param \ECInternet\Sage300TaxRules\Api\TxclassRepositoryInterface  $txclassRepository
     * @param \ECInternet\Sage300TaxRules\Api\TxgrpRepositoryInterface    $txgrpRepository
     * @param \ECInternet\Sage300TaxRules\Api\TxrateRepositoryInterface   $txrateRepository
     * @param \ECInternet\Sage300TaxRules\Api\TxstatedRepositoryInterface $txstatedRepository
     * @param \ECInternet\Sage300TaxRules\Logger\Logger                   $logger
     */
    public function __construct(
        AddressRepositoryInterface $addressRepository,
        TxclassRepositoryInterface $txclassRepository,
        TxgrpRepositoryInterface $txgrpRepository,
        TxrateRepositoryInterface $txrateRepository,
        TxstatedRepositoryInterface $txstatedRepository,
        Logger $logger
    ) {
        $this->_addressRepository  = $addressRepository;
        $this->_txclassRepository  = $txclassRepository;
        $this->_txgrpRepository    = $txgrpRepository;
        $this->_txrateRepository   = $txrateRepository;
        $this->_txstatedRepository = $txstatedRepository;
        $this->_logger             = $logger;
    }

    /**
     * Calculate Sage rate
     *
     * @param \Magento\Quote\Api\Data\AddressInterface $shippingAddress
     *
     * @return float|null
     */
    public function getSageRate(
        AddressInterface $shippingAddress
    ) {
        $this->log('getSageRate()', ['shippingAddress' => $shippingAddress->getData()]);

        $address = $this->getCustomerAddress($shippingAddress);
        if ($address === null) {
            $this->log('getSageRate()', ['message' => 'Address is null']);
            return null;
        }

        if ($taxGroupCode = $this->getAddressTaxGroupCode($address)) {
            if ($taxGroup = $this->getTaxGroup($taxGroupCode)) {
                $taxAuthority1 = $taxGroup->getTaxAuthority1();
                $this->log('getSageRate()', ['taxAuthority1' => $taxAuthority1]);

                if (empty($taxAuthority1)) {
                    $this->log('getSageRate()', ['message' => 'Tax Authority 1 is empty']);
                    return null;
                }

                $addressTaxClass1 = $this->getAddressTaxClass1($address);
                if (empty($addressTaxClass1)) {
                    $this->log('getSageRate()', ['message' => 'Address Tax Class 1 is empty']);
                    return null;
                }

                $taxClass = $this->getTaxClass($taxAuthority1, $addressTaxClass1);
                if ($taxClass === null) {
                    $this->log('getSageRate()', ['message' => 'Tax Class not found']);
                    return null;
                }

                if ($taxClass->getExempt()) {
                    $this->log('getSageRate()', ['message' => 'Tax Class is exempt']);
                    return 0.0;
                }

                $taxCalculationMethod = $taxGroup->getTaxCalculationMethod();
                if ($taxCalculationMethod === null) {
                    $this->log('getSageRate()', ['message' => 'Tax Calculation Method is null']);
                    return 0.0;
                }

                // Rate placeholders
                $taxRate1 = 0.0;
                $taxRate2 = 0.0;
                $taxRate3 = 0.0;
                $taxRate4 = 0.0;
                $taxRate5 = 0.0;

                if ($taxCalculationMethod === 1) {
                    $this->log('getSageRate() - Calculation method: By summary');
                    $taxRate = $this->getTaxRate($taxAuthority1, $addressTaxClass1);
                    if ($taxRate === null) {
                        $this->log("getSageRate() - Unable to find tax rate with tax authority [$taxAuthority1] and buyer class [$addressTaxClass1]");
                        return 0.0;
                    }

                    $taxRate1 = $taxRate->getItemRate1();
                    $this->log('getSageRate()', ['taxRate1' => $taxRate1]);
                } elseif ($taxCalculationMethod === 2) {
                    $this->log('getSageRate() - Calculation method: By detail');
                    $taxStateDetails = $this->getTaxStateDetails($taxGroupCode, $taxAuthority1);
                    if ($taxStateDetails === null) {
                        $this->log("getSageRate() - Unable to find tax state details with tax group [$taxGroupCode] and tax authority [$taxAuthority1]");
                        return 0.0;
                    }

                    $taxRate1 = $taxStateDetails->getTaxRate0101();
                    $this->log('getSageRate()', ['taxRate1' => $taxRate1]);
                }

                $totalTaxRate = $taxRate1 + $taxRate2 + $taxRate3 + $taxRate4 + $taxRate5;
                $this->log('getSageRate()', ['totalTaxRate' => $totalTaxRate]);

                return $totalTaxRate;
            }
        }

        return null;
    }

    private function getCustomerAddress(
        AddressInterface $address
    ) {
        $this->log('getCustomerAddress()');

        $customerAddressId = $address->getCustomerAddressId();
        if ($customerAddressId === null) {
            $this->log('getCustomerAddress()', ['message' => 'Customer Address ID is null']);
            return null;
        }
        if (!is_numeric($customerAddressId)) {
            $this->log('getCustomerAddress()', ['message' => 'Customer Address ID is not numeric']);
            return null;
        }

        return $this->getAddressById((int)$customerAddressId);
    }

    /**
     * @param \Magento\Customer\Api\Data\AddressInterface $address
     *
     * @return string|null
     */
    private function getAddressTaxGroupCode(
        \Magento\Customer\Api\Data\AddressInterface $address
    ) {
        $this->log('getAddressTaxGroupCode()');

        $addressTaxGroupCode = $this->getAddressCustomAttribute($address, 'codetaxgrp');
        if ($addressTaxGroupCode !== null) {
            return (string)$addressTaxGroupCode;
        }

        return null;
    }

    /**
     * @param \Magento\Customer\Api\Data\AddressInterface $address
     *
     * @return int|null
     */
    private function getAddressTaxClass1(
        \Magento\Customer\Api\Data\AddressInterface $address
    ) {
        $this->log('getAddressTaxClass1()');

        $addressTaxClass1 = $this->getAddressCustomAttribute($address, 'taxstts1');
        if (is_numeric($addressTaxClass1)) {
            return (int)$addressTaxClass1;
        }

        return null;
    }

    private function getAddressCustomAttribute(
        \Magento\Customer\Api\Data\AddressInterface $address,
        string $attributeCode
    ) {
        if ($customAttribute = $address->getCustomAttribute($attributeCode)) {
            if ($customAttributeValue = $customAttribute->getValue()) {
                return $customAttributeValue;
            } else {
                $this->log('getAddressCustomAttribute()', ['message' => "'$attributeCode' attribute value not set on address"]);
            }
        } else {
            $this->log('getAddressCustomAttribute()', ['message' => "'$attributeCode' attribute not set on address"]);
        }

        return null;
    }

    private function getAddressById(int $customerAddressId)
    {
        try {
            return $this->_addressRepository->getById($customerAddressId);
        } catch (Exception $e) {
            $this->log('getAddress()', ['customerAddressId' => $customerAddressId, 'exception' => $e->getMessage()]);
        }

        return null;
    }

    /**
     * @param string $taxAuthority
     * @param int    $taxClass
     *
     * @return \ECInternet\Sage300TaxRules\Api\Data\TxclassInterface|null
     */
    public function getTaxClass(string $taxAuthority, int $taxClass)
    {
        return $this->_txclassRepository->getByAuthorityAndClass($taxAuthority, $taxClass);
    }

    /**
     * @param string $taxGroup
     * @param int    $transactionType
     *
     * @return \ECInternet\Sage300TaxRules\Api\Data\TxgrpInterface|null
     */
    private function getTaxGroup(string $taxGroup, int $transactionType = 1)
    {
        return $this->_txgrpRepository->get($taxGroup, $transactionType);
    }


    /**
     * @param string $taxAuthority
     * @param int    $buyerClass
     *
     * @return \ECInternet\Sage300TaxRules\Api\Data\TxrateInterface|null
     */
    public function getTaxRate(string $taxAuthority, int $buyerClass)
    {
        return $this->_txrateRepository->get($taxAuthority, Txrate::TRANSACTION_TYPE_SALES, $buyerClass);
    }

    /**
     * @param string $taxGroup
     * @param string $taxAuthority
     *
     * @return \ECInternet\Sage300TaxRules\Api\Data\TxstatedInterface|null
     */
    public function getTaxStateDetails(string $taxGroup, string $taxAuthority)
    {
        return $this->_txstatedRepository->getByGroupAndAuthority($taxGroup, $taxAuthority);
    }

    /**
     * Write to extension log
     *
     * @param string $message
     * @param array  $extra
     *
     * @return void
     */
    private function log(string $message, array $extra = [])
    {
        $this->_logger->info('Model/TaxCalculator - ' . $message, $extra);
    }
}
