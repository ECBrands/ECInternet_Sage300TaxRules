<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Model\Sales\Total\Quote;

use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Model\Quote;
use ECInternet\Sage300TaxRules\Model\TaxCalculator;

class Tax extends \Magento\Tax\Model\Sales\Total\Quote\Tax
{
    /**
     * @var \ECInternet\Sage300TaxRules\Logger\Logger
     */
    private $_logger;

    /**
     * @var \ECInternet\Sage300TaxRules\Model\TaxCalculator
     */
    private $_taxCalculator;

    /**
     * Tax constructor.
     *
     * @param \Magento\Tax\Model\Config                              $taxConfig
     * @param \Magento\Tax\Api\TaxCalculationInterface               $taxCalculationService
     * @param \Magento\Tax\Api\Data\QuoteDetailsInterfaceFactory     $quoteDetailsDataObjectFactory
     * @param \Magento\Tax\Api\Data\QuoteDetailsItemInterfaceFactory $quoteDetailsItemDataObjectFactory
     * @param \Magento\Tax\Api\Data\TaxClassKeyInterfaceFactory      $taxClassKeyDataObjectFactory
     * @param \Magento\Customer\Api\Data\AddressInterfaceFactory     $customerAddressFactory
     * @param \Magento\Customer\Api\Data\RegionInterfaceFactory      $customerAddressRegionFactory
     * @param \Magento\Tax\Helper\Data                               $taxData
     * @param \ECInternet\Sage300TaxRules\Logger\Logger              $logger
     * @param \ECInternet\Sage300TaxRules\Model\TaxCalculator        $taxCalculator
     * @param \Magento\Framework\Serialize\Serializer\Json|null      $serializer
     */
    public function __construct(
        \Magento\Tax\Model\Config $taxConfig,
        \Magento\Tax\Api\TaxCalculationInterface $taxCalculationService,
        \Magento\Tax\Api\Data\QuoteDetailsInterfaceFactory $quoteDetailsDataObjectFactory,
        \Magento\Tax\Api\Data\QuoteDetailsItemInterfaceFactory $quoteDetailsItemDataObjectFactory,
        \Magento\Tax\Api\Data\TaxClassKeyInterfaceFactory $taxClassKeyDataObjectFactory,
        \Magento\Customer\Api\Data\AddressInterfaceFactory $customerAddressFactory,
        \Magento\Customer\Api\Data\RegionInterfaceFactory $customerAddressRegionFactory,
        \Magento\Tax\Helper\Data $taxData,
        \ECInternet\Sage300TaxRules\Logger\Logger $logger,
        TaxCalculator $taxCalculator,
        \Magento\Framework\Serialize\Serializer\Json $serializer = null
    ) {
        parent::__construct($taxConfig, $taxCalculationService, $quoteDetailsDataObjectFactory, $quoteDetailsItemDataObjectFactory, $taxClassKeyDataObjectFactory, $customerAddressFactory, $customerAddressRegionFactory, $taxData, $serializer);

        $this->_logger = $logger;
        $this->_taxCalculator = $taxCalculator;
    }

    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        $this->log('collect()');

        $this->clearValues($total);
        if (!$shippingAssignment->getItems()) {
            return $this;
        }

        $baseTaxDetails = $this->getQuoteTaxDetails($shippingAssignment, $total, true);
        $taxDetails = $this->getQuoteTaxDetails($shippingAssignment, $total, false);

        //Populate address and items with tax calculation results
        $itemsByType = $this->organizeItemTaxDetailsByType($taxDetails, $baseTaxDetails);
        if (isset($itemsByType[self::ITEM_TYPE_PRODUCT])) {
            $this->processProductItems($shippingAssignment, $itemsByType[self::ITEM_TYPE_PRODUCT], $total);
        }

        if (isset($itemsByType[self::ITEM_TYPE_SHIPPING])) {
            $shippingTaxDetails = $itemsByType[self::ITEM_TYPE_SHIPPING][self::ITEM_CODE_SHIPPING][self::KEY_ITEM];
            $baseShippingTaxDetails =
                $itemsByType[self::ITEM_TYPE_SHIPPING][self::ITEM_CODE_SHIPPING][self::KEY_BASE_ITEM];
            $this->processShippingTaxInfo($shippingAssignment, $total, $shippingTaxDetails, $baseShippingTaxDetails);
        }

        //Process taxable items that are not product or shipping
        $this->processExtraTaxables($total, $itemsByType);

        // CUSTOM START
        $taxAmount = $this->getTaxAmount($quote, $shippingAssignment);
        $this->log('collect()', ['taxAmount' => $taxAmount]);

        if ($taxAmount !== null) {
            $total->setTaxAmount($taxAmount);
            $total->setGrandTotal($total->getGrandTotal() + $taxAmount);

            $total->setBaseTaxAmount($taxAmount);
            $total->setBaseGrandTotal($total->getBaseGrandTotal() + $taxAmount);
        }
        // CUSTOM END

        //Save applied taxes for each item and the quote in aggregation
        $this->processAppliedTaxes($total, $shippingAssignment, $itemsByType);

        if ($this->includeExtraTax()) {
            $total->addTotalAmount('extra_tax', $total->getExtraTaxAmount());
            $total->addBaseTotalAmount('extra_tax', $total->getBaseExtraTaxAmount());
        }

        return $this;
    }

    /**
     * @param \Magento\Quote\Model\Quote                          $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     *
     * @return float|null
     */
    private function getTaxAmount(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment
    ) {
        $this->log('getTaxAmount()', ['quoteSubtotal' => $quote->getSubtotal()]);

        if ($shipping = $shippingAssignment->getShipping()) {
            if ($shippingAddress = $shipping->getAddress()) {
                $sageRate = $this->_taxCalculator->getSageRate($shippingAddress);
                $this->log('getTaxAmount()', ['sageRate' => $sageRate]);

                if ($sageRate !== null) {
                    $taxRate = ($sageRate > 0) ? $sageRate / 100 : 0;
                    $this->log('getTaxAmount()', ['taxRate' => $taxRate]);

                    return $taxRate * $quote->getSubtotal();
                } else {
                    $this->log('getTaxAmount() - Null sageRate');
                }
            } else {
                $this->log('getTaxAmount() - Null shippingAddress');
            }
        } else {
            $this->log('getTaxAmount() - Null shipping');
        }

        return null;
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
        $this->_logger->info('Model/Sales/Total/Quote/Tax - ' . $message, $extra);
    }
}
