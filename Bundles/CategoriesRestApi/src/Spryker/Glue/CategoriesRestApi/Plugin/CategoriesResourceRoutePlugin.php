<?php
/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CategoriesRestApi\Plugin;

use Generated\Shared\Transfer\RestCategoryTreesAttributesTransfer;
use Spryker\Glue\CategoriesRestApi\CategoriesRestApiConfig;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class CategoriesResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /**
     * {@inheritDoc}
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection): ResourceRouteCollectionInterface
    {
        $resourceRouteCollection->addGet(
            CategoriesRestApiConfig::RESOURCE_CATEGORY_TREES_ACTION_NAME,
            CategoriesRestApiConfig::RESOURCE_CATEGORY_TREES_IS_PROTECTED
        );

        return $resourceRouteCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function getResourceType(): string
    {
        return CategoriesRestApiConfig::RESOURCE_CATEGORY_TREES;
    }

    /**
     * {@inheritDoc}
     */
    public function getController(): string
    {
        return CategoriesRestApiConfig::CONTROLLER_CATEGORIES;
    }

    /**
     * {@inheritDoc}
     */
    public function getResourceAttributesClassName(): string
    {
        return RestCategoryTreesAttributesTransfer::class;
    }
}
