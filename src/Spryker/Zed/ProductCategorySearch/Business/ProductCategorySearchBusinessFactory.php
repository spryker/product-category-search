<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductCategorySearch\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\ProductCategorySearch\Business\Builder\ProductCategoryTreeBuilder;
use Spryker\Zed\ProductCategorySearch\Business\Builder\ProductCategoryTreeBuilderInterface;
use Spryker\Zed\ProductCategorySearch\Business\Expander\ProductPageCategoryExpander;
use Spryker\Zed\ProductCategorySearch\Business\Expander\ProductPageCategoryExpanderInterface;
use Spryker\Zed\ProductCategorySearch\Business\Expander\ProductPageDataExpander;
use Spryker\Zed\ProductCategorySearch\Business\Expander\ProductPageDataExpanderInterface;
use Spryker\Zed\ProductCategorySearch\Business\Expander\ProductPageMapCategoryExpander;
use Spryker\Zed\ProductCategorySearch\Business\Expander\ProductPageMapCategoryExpanderInterface;

/**
 * @method \Spryker\Zed\ProductCategorySearch\Persistence\ProductCategorySearchRepositoryInterface getRepository()
 * @method \Spryker\Zed\ProductCategorySearch\ProductCategorySearchConfig getConfig()
 */
class ProductCategorySearchBusinessFactory extends AbstractBusinessFactory
{
    public function createProductPageCategoryExpander(): ProductPageCategoryExpanderInterface
    {
        return new ProductPageCategoryExpander(
            $this->getRepository(),
        );
    }

    public function createProductPageDataExpander(): ProductPageDataExpanderInterface
    {
        return new ProductPageDataExpander(
            $this->createProductCategoryTreeBuilder(),
        );
    }

    public function createProductPageMapCategoryExpander(): ProductPageMapCategoryExpanderInterface
    {
        return new ProductPageMapCategoryExpander();
    }

    public function createProductCategoryTreeBuilder(): ProductCategoryTreeBuilderInterface
    {
        return new ProductCategoryTreeBuilder(
            $this->getRepository(),
        );
    }
}
