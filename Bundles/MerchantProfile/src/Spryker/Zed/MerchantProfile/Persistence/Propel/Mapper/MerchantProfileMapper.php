<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProfile\Persistence\Propel\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\MerchantProfileTransfer;
use Generated\Shared\Transfer\UrlTransfer;
use Orm\Zed\MerchantProfile\Persistence\SpyMerchantProfile;

class MerchantProfileMapper implements MerchantProfileMapperInterface
{
    /**
     * @param \Orm\Zed\MerchantProfile\Persistence\SpyMerchantProfile $merchantProfileEntity
     * @param \Generated\Shared\Transfer\MerchantProfileTransfer $merchantProfileTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantProfileTransfer
     */
    public function mapMerchantProfileEntityToMerchantProfileTransfer(
        SpyMerchantProfile $merchantProfileEntity,
        MerchantProfileTransfer $merchantProfileTransfer
    ): MerchantProfileTransfer {
        $merchantProfileTransfer->fromArray(
            $merchantProfileEntity->toArray(),
            true
        );

        $urlEntities = $merchantProfileEntity->getSpyUrls();
        if (count($urlEntities)) {
            $urlTransfers = new ArrayObject();
            foreach ($urlEntities as $urlEntity) {
                $urlTransfers->append((new UrlTransfer())->fromArray($urlEntity->toArray(), true));
            }

            $merchantProfileTransfer->setUrlCollection($urlTransfers);
        }

        return $merchantProfileTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantProfileTransfer $merchantProfileTransfer
     * @param \Orm\Zed\MerchantProfile\Persistence\SpyMerchantProfile $spyMerchantProfile
     *
     * @return \Orm\Zed\MerchantProfile\Persistence\SpyMerchantProfile
     */
    public function mapMerchantProfileTransferToMerchantProfileEntity(
        MerchantProfileTransfer $merchantProfileTransfer,
        SpyMerchantProfile $spyMerchantProfile
    ): SpyMerchantProfile {
        $spyMerchantProfile->fromArray(
            $merchantProfileTransfer->modifiedToArray(false)
        );

        return $spyMerchantProfile;
    }
}
