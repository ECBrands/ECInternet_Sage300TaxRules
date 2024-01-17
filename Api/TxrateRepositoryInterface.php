<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Api;

interface TxrateRepositoryInterface
{
    public function get(string $taxAuthority, int $transactionType, int $buyerClass);
}
