<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CompanyBusinessUnitsRestApi\Plugin\CompanyUsersRestApi;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUserAttributesTransfer;
use Spryker\Glue\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserAttributesMapperPluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \Spryker\Glue\CompanyBusinessUnitsRestApi\CompanyBusinessUnitsRestApiFactory getFactory()
 */
class CompanyBusinessUnitMapperPlugin extends AbstractPlugin implements CompanyUserAttributesMapperPluginInterface
{
    /**
     * {@inheritdoc}
     * - Maps company business unit data to RestCompanyUserAttributesTransfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\RestCompanyUserAttributesTransfer $restCompanyUserAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserAttributesTransfer
     */
    public function mapCompanyUserAttributes(
        CompanyUserTransfer $companyUserTransfer,
        RestCompanyUserAttributesTransfer $restCompanyUserAttributesTransfer
    ): RestCompanyUserAttributesTransfer {
        return $this->getFactory()->createCompanyBusinessUnitMapper()->mapCompanyUserAttributes($companyUserTransfer, $restCompanyUserAttributesTransfer);
    }
}
