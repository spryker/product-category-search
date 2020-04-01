<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationshipGui\Dependency\Facade;

use Generated\Shared\Transfer\MerchantCollectionTransfer;
use Generated\Shared\Transfer\MerchantCriteriaFilterTransfer;

class MerchantRelationshipGuiToMerchantFacadeBridge implements MerchantRelationshipGuiToMerchantFacadeInterface
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
     * This shim exists for BC reasons, will be removed when this module gets a major.
     * It will be highlighted because the refactoring of MerchantFacade removed the getMerchants function.
     *
     * @param \Generated\Shared\Transfer\MerchantCriteriaFilterTransfer $merchantCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantCollectionTransfer
     */
    public function get(MerchantCriteriaFilterTransfer $merchantCriteriaFilterTransfer): MerchantCollectionTransfer
    {
        return $this->merchantFacade->get($merchantCriteriaFilterTransfer);
    }
}
