<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantGui\Dependency\Facade;

use Generated\Shared\Transfer\MerchantAddressTransfer;
use Generated\Shared\Transfer\MerchantTransfer;

class MerchantGuiToMerchantFacadeBridge implements MerchantGuiToMerchantFacadeInterface
{
    /**
     * @var \Spryker\Zed\Merchant\Business\MerchantFacadeInterface
     */
    protected $merchantFacade;

    /**
     * @param \Spryker\Zed\Merchant\Business\MerchantFacadeInterface $merchantFacade
     */
    public function __construct($merchantFacade)
    {
        $this->merchantFacade = $merchantFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantTransfer
     */
    public function createMerchant(MerchantTransfer $merchantTransfer): MerchantTransfer
    {
        return $this->merchantFacade->createMerchant($merchantTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantTransfer
     */
    public function updateMerchant(MerchantTransfer $merchantTransfer): MerchantTransfer
    {
        return $this->merchantFacade->updateMerchant($merchantTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return void
     */
    public function deleteMerchant(MerchantTransfer $merchantTransfer): void
    {
        $this->merchantFacade->deleteMerchant($merchantTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantTransfer|null
     */
    public function getMerchantById(MerchantTransfer $merchantTransfer): ?MerchantTransfer
    {
        return $this->merchantFacade->getMerchantById($merchantTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantTransfer|null
     */
    public function findMerchantById(MerchantTransfer $merchantTransfer): ?MerchantTransfer
    {
        return $this->merchantFacade->findMerchantById($merchantTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantTransfer|null
     */
    public function findMerchantByEmail(MerchantTransfer $merchantTransfer): ?MerchantTransfer
    {
        return $this->merchantFacade->findMerchantByEmail($merchantTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantAddressTransfer $merchantAddressTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantAddressTransfer|null
     */
    public function findMerchantAddressById(MerchantAddressTransfer $merchantAddressTransfer): ?MerchantAddressTransfer
    {
        return $this->merchantFacade->findMerchantAddressById($merchantAddressTransfer);
    }

    /**
     * @param string $currentStatus
     *
     * @return string[]
     */
    public function getNextStatuses(string $currentStatus): array
    {
        return $this->merchantFacade->getNextStatuses($currentStatus);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantAddressTransfer $merchantAddressTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantAddressTransfer
     */
    public function createMerchantAddress(MerchantAddressTransfer $merchantAddressTransfer): MerchantAddressTransfer
    {
        return $this->merchantFacade->createMerchantAddress($merchantAddressTransfer);
    }
}
