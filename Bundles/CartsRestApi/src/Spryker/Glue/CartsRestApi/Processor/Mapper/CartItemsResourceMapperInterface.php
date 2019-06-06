<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\RestCartItemsAttributesTransfer;
use Generated\Shared\Transfer\RestItemsAttributesTransfer;

interface CartItemsResourceMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\RestItemsAttributesTransfer
     */
    public function mapCartItemAttributes(ItemTransfer $itemTransfer): RestItemsAttributesTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestCartItemsAttributesTransfer $restCartItemsAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    public function mapItemAttributesToItemTransfer(RestCartItemsAttributesTransfer $restCartItemsAttributesTransfer): ItemTransfer;
}
