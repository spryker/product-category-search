<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductCategorySearch\Persistence;

use Orm\Zed\Category\Persistence\SpyCategoryAttributeQuery;
use Orm\Zed\Category\Persistence\SpyCategoryNodeQuery;
use Orm\Zed\ProductCategory\Persistence\SpyProductCategoryQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use Spryker\Zed\ProductCategorySearch\Persistence\Propel\Mapper\ProductCategoryMapper;
use Spryker\Zed\ProductCategorySearch\ProductCategorySearchDependencyProvider;

/**
 * @method \Spryker\Zed\ProductCategorySearch\ProductCategorySearchConfig getConfig()
 * @method \Spryker\Zed\ProductCategorySearch\Persistence\ProductCategorySearchRepositoryInterface getRepository()
 */
class ProductCategorySearchPersistenceFactory extends AbstractPersistenceFactory
{
    public function createProductCategoryMapper(): ProductCategoryMapper
    {
        return new ProductCategoryMapper();
    }

    public function getProductCategoryPropelQuery(): SpyProductCategoryQuery
    {
        return $this->getProvidedDependency(ProductCategorySearchDependencyProvider::PROPEL_QUERY_PRODUCT_CATEGORY);
    }

    public function getCategoryNodePropelQuery(): SpyCategoryNodeQuery
    {
        return $this->getProvidedDependency(ProductCategorySearchDependencyProvider::PROPEL_QUERY_CATEGORY_NODE);
    }

    public function getCategoryAttributePropelQuery(): SpyCategoryAttributeQuery
    {
        return $this->getProvidedDependency(ProductCategorySearchDependencyProvider::PROPEL_QUERY_CATEGORY_ATTRIBUTE);
    }
}
