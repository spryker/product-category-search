<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceProductSchedule\Business\Currency;

use Generated\Shared\Transfer\CurrencyTransfer;
use Spryker\Zed\Currency\Business\Model\Exception\CurrencyNotFoundException;
use Spryker\Zed\PriceProductSchedule\Dependency\Facade\PriceProductScheduleToCurrencyFacadeInterface;

class CurrencyFinder implements CurrencyFinderInterface
{
    /**
     * @var \Spryker\Zed\PriceProductSchedule\Dependency\Facade\PriceProductScheduleToCurrencyFacadeInterface
     */
    protected $currencyFacade;

    /**
     * @var array
     */
    protected $currencyCache = [];

    /**
     * @param \Spryker\Zed\PriceProductSchedule\Dependency\Facade\PriceProductScheduleToCurrencyFacadeInterface $currencyFacade
     */
    public function __construct(PriceProductScheduleToCurrencyFacadeInterface $currencyFacade)
    {
        $this->currencyFacade = $currencyFacade;
    }

    /**
     * @param string $isoCode
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer|null
     */
    public function findCurrencyByIsoCode(string $isoCode): ?CurrencyTransfer
    {
        if (isset($this->currencyCache[$isoCode])) {
            return $this->currencyCache[$isoCode];
        }

        try {
            $currencyTransfer = $this->currencyFacade->fromIsoCode($isoCode);

            $this->currencyCache[$isoCode] = $currencyTransfer;

            return $this->currencyCache[$isoCode];
        } catch (CurrencyNotFoundException $e) {
            return null;
        }
    }
}
