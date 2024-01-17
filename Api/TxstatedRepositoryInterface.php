<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Api;

interface TxstatedRepositoryInterface
{
    /**
     * Retrieve record
     *
     * @param string $taxGroup
     * @param int    $transactionType
     * @param int    $version
     * @param int    $taxAuthorityLineNumber
     *
     * @return \ECInternet\Sage300TaxRules\Api\Data\TxstatedInterface|null
     */
    public function get(string $taxGroup, int $transactionType, int $version, int $taxAuthorityLineNumber);

    /**
     * Retrieve record by tax group and tax authority
     *
     * @param string $taxGroup
     * @param string $taxAuthority
     *
     * @return \ECInternet\Sage300TaxRules\Api\Data\TxstatedInterface|null
     */
    public function getByGroupAndAuthority(string $taxGroup, string $taxAuthority);
}
