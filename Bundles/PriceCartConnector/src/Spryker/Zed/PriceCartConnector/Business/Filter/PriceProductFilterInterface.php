<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceCartConnector\Business\Filter;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\PriceProductFilterTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface PriceProductFilterInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductFilterTransfer
     */
    public function createPriceProductFilterTransfer(
        QuoteTransfer $quoteTransfer,
        ItemTransfer $itemTransfer
    ): PriceProductFilterTransfer;
}
