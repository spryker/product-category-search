<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductCategorySearch\Persistence\Propel\Mapper;

use Orm\Zed\Category\Persistence\SpyCategoryStore;
use Orm\Zed\ProductCategory\Persistence\SpyProductCategory;
use Propel\Runtime\Collection\Collection;

class ProductCategoryMapper
{
    /**
     * @var array<int, string|null>
     */
    protected static array $storeCache = [];

    /**
     * @param \Propel\Runtime\Collection\Collection<\Orm\Zed\ProductCategory\Persistence\SpyProductCategory> $productCategoryEntities
     * @param array<int, array<string, list<\Orm\Zed\ProductCategory\Persistence\SpyProductCategory>>> $mappedProductCategoryEntities
     *
     * @return array<int, array<string, list<\Orm\Zed\ProductCategory\Persistence\SpyProductCategory>>>
     */
    public function mapProductCategoryEntitiesByIdProductAbstractAndStore(
        Collection $productCategoryEntities,
        array $mappedProductCategoryEntities
    ): array {
        foreach ($productCategoryEntities as $productCategoryEntity) {
            $mappedProductCategoryEntities = $this->mapProductCategoryEntityByIdProductAbstractAndStore(
                $productCategoryEntity,
                $mappedProductCategoryEntities,
            );
        }

        return $mappedProductCategoryEntities;
    }

    /**
     * @param \Orm\Zed\ProductCategory\Persistence\SpyProductCategory $productCategoryEntity
     * @param array<int, array<string, list<\Orm\Zed\ProductCategory\Persistence\SpyProductCategory>>> $productCategoryEntities
     *
     * @return array<int, array<string, list<\Orm\Zed\ProductCategory\Persistence\SpyProductCategory>>>
     */
    protected function mapProductCategoryEntityByIdProductAbstractAndStore(
        SpyProductCategory $productCategoryEntity,
        array $productCategoryEntities
    ): array {
        foreach ($productCategoryEntity->getSpyCategory()->getSpyCategoryStores() as $categoryStoreEntity) {
            $idProductAbstract = $productCategoryEntity->getFkProductAbstract();
            $storeName = $this->getStoreName($categoryStoreEntity);

            $productCategoryEntities[$idProductAbstract][$storeName][] = $productCategoryEntity;
        }

        return $productCategoryEntities;
    }

    protected function getStoreName(SpyCategoryStore $spyCategoryStore): string
    {
        if (!isset(static::$storeCache[$spyCategoryStore->getFkStore()])) {
            static::$storeCache[$spyCategoryStore->getFkStore()] = (string)$spyCategoryStore->getSpyStore()->getName();
        }

        return static::$storeCache[$spyCategoryStore->getFkStore()];
    }
}
