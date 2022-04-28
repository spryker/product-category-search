<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductCategorySearch\Communication\Plugin\ProductPageSearch;

use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageDataExpanderInterface;

/**
 * @method \Spryker\Zed\ProductCategorySearch\Communication\ProductCategorySearchCommunicationFactory getFactory()
 * @method \Spryker\Zed\ProductCategorySearch\Business\ProductCategorySearchFacadeInterface getFacade()
 * @method \Spryker\Zed\ProductCategorySearch\ProductCategorySearchConfig getConfig()
 */
class ProductCategoryPageDataExpanderPlugin extends AbstractPlugin implements ProductPageDataExpanderInterface
{
    /**
     * {@inheritDoc}
     * - Expands `ProductPageSearchTransfer` with category related data.
     * - Populates `ProductPageSearchTransfer.allParentCategoryIds`.
     * - Populates `ProductPageSearchTransfer.categoryNames`.
     * - Populates `ProductPageSearchTransfer.sortedCategories`.
     *
     * @api
     *
     * @param array<string, mixed> $productData
     * @param \Generated\Shared\Transfer\ProductPageSearchTransfer $productAbstractPageSearchTransfer
     *
     * @return void
     */
    public function expandProductPageData(array $productData, ProductPageSearchTransfer $productAbstractPageSearchTransfer)
    {
        $this->getFacade()->expandProductPageDataWithCategoryData($productData, $productAbstractPageSearchTransfer);
    }
}
