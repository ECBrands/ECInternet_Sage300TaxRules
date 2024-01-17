<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Sage300TaxRules\Api;

interface TxgrpRepositoryInterface
{
    public function get(string $taxGroup, int $transactionType);
}
