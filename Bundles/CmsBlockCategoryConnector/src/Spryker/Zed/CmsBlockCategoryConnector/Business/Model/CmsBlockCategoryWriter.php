<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsBlockCategoryConnector\Business\Model;

use Generated\Shared\Transfer\CategoryTransfer;
use Generated\Shared\Transfer\CmsBlockTransfer;
use Orm\Zed\CmsBlockCategoryConnector\Persistence\SpyCmsBlockCategoryConnector;
use Orm\Zed\CmsBlockCategoryConnector\Persistence\SpyCmsBlockCategoryConnectorQuery;
use Spryker\Shared\CmsBlockCategoryConnector\CmsBlockCategoryConnectorConfig;
use Spryker\Shared\CmsBlockCategoryConnector\CmsBlockCategoryConnectorConstants;
use Spryker\Zed\CmsBlockCategoryConnector\Business\Exception\CmsBlockCategoryPositionNotFound;
use Spryker\Zed\CmsBlockCategoryConnector\Dependency\Facade\CmsBlockCategoryConnectorToTouchInterface;
use Spryker\Zed\CmsBlockCategoryConnector\Dependency\QueryContainer\CmsBlockCategoryConnectorToCategoryQueryContainerInterface;
use Spryker\Zed\CmsBlockCategoryConnector\Persistence\CmsBlockCategoryConnectorQueryContainerInterface;
use Spryker\Zed\PropelOrm\Business\Transaction\DatabaseTransactionHandlerTrait;

class CmsBlockCategoryWriter implements CmsBlockCategoryWriterInterface
{

    use DatabaseTransactionHandlerTrait;

    /**
     * @var \Spryker\Zed\CmsBlockCategoryConnector\Persistence\CmsBlockCategoryConnectorQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var \Spryker\Zed\CmsBlockCategoryConnector\Dependency\Facade\CmsBlockCategoryConnectorToTouchInterface
     */
    protected $touchFacade;

    /**
     * @var
     */
    protected $categoryQueryContainer;

    /**
     * @param \Spryker\Zed\CmsBlockCategoryConnector\Persistence\CmsBlockCategoryConnectorQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\CmsBlockCategoryConnector\Dependency\Facade\CmsBlockCategoryConnectorToTouchInterface $touchFacade
     * @param CmsBlockCategoryConnectorToCategoryQueryContainerInterface $categoryQueryContainer
     */
    public function __construct(
        CmsBlockCategoryConnectorQueryContainerInterface $queryContainer,
        CmsBlockCategoryConnectorToTouchInterface $touchFacade,
        CmsBlockCategoryConnectorToCategoryQueryContainerInterface $categoryQueryContainer
    ) {
        $this->queryContainer = $queryContainer;
        $this->touchFacade = $touchFacade;
        $this->categoryQueryContainer = $categoryQueryContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\CmsBlockTransfer $cmsBlockTransfer
     *
     * @return void
     */
    public function updateCmsBlock(CmsBlockTransfer $cmsBlockTransfer)
    {
        $this->handleDatabaseTransaction(function () use ($cmsBlockTransfer) {
            $this->updateCmsBlockCategoryRelationsTransaction($cmsBlockTransfer);
        });
    }

    /**
     * @param CategoryTransfer $categoryTransfer
     *
     * @return void
     */
    public function updateCategory(CategoryTransfer $categoryTransfer)
    {
        $this->handleDatabaseTransaction(function () use ($categoryTransfer) {
            $this->updateCategoryCmsBlockRelationsTransaction($categoryTransfer);
        });
    }

    /**
     * @param CategoryTransfer $categoryTransfer
     *
     * @return void
     */
    protected function updateCategoryCmsBlockRelationsTransaction(CategoryTransfer $categoryTransfer)
    {
        $spyCategory = $this->categoryQueryContainer
            ->queryCategoryById($categoryTransfer->getIdCategory())
            ->findOne();

        $touchOnly = false;

        if ($spyCategory->getFkCategoryTemplate() !== $categoryTransfer->getFkCategoryTemplate()) {
            $touchOnly = true;
        }

        $this->deleteCategoryCmsBlockRelations($categoryTransfer, $touchOnly);
        $this->createCategoryCmsBlockRelations($categoryTransfer, $touchOnly);
    }

    /**
     * @param CategoryTransfer $categoryTransfer
     * @param bool $touchOnly
     *
     * @return void
     */
    protected function deleteCategoryCmsBlockRelations(CategoryTransfer $categoryTransfer, $touchOnly = false)
    {
        $categoryTransfer->requireIdCategory();

        $query = $this->queryContainer
            ->queryCmsBlockCategoryConnectorByIdCategory($categoryTransfer->getIdCategory(), $categoryTransfer->getFkCategoryTemplate());

        if (!$touchOnly) {
            $this->deleteRelations($query);
        }

        $this->touchDeleteCategoryCmsBlockRelation($query);
    }

    /**
     * @param SpyCmsBlockCategoryConnectorQuery $query
     */
    protected function touchDeleteCategoryCmsBlockRelation(SpyCmsBlockCategoryConnectorQuery $query)
    {
        foreach ($query->find() as $relation) {
            $this->touchFacade->touchDeleted(
                CmsBlockCategoryConnectorConfig::RESOURCE_TYPE_CMS_BLOCK_CATEGORY_CONNECTOR,
                $relation->getFkCategory()
            );

            $this->touchFacade->touchDeleted(
                CmsBlockCategoryConnectorConfig::RESOURCE_TYPE_CMS_BLOCK_CATEGORY_POSITION,
                $relation->getFkCmsBlockCategoryPosition()
            );
        }
    }

    /**
     * @param CategoryTransfer $categoryTransfer
     * @param bool $touchOnly
     *
     * @return void
     */
    protected function createCategoryCmsBlockRelations(CategoryTransfer $categoryTransfer, $touchOnly = false)
    {
        $categoryTransfer->requireIdCategory();

        foreach ($categoryTransfer->getIdCmsBlocks() as $idCmsBlockCategoryPosition => $idCmsBlocks) {
            if (!$touchOnly) {
                $this->createRelations($idCmsBlocks, [$categoryTransfer->getIdCategory()], $idCmsBlockCategoryPosition);
            }

            $this->touchActiveCategoryCmsBlockRelation([$categoryTransfer->getIdCategory()], $idCmsBlockCategoryPosition);
        }
    }

    /**
     * @param array $idCategories
     * @param int $idCmsBlockCategoryPosition
     *
     * @return void
     */
    protected function touchActiveCategoryCmsBlockRelation(array $idCategories, $idCmsBlockCategoryPosition)
    {
        foreach ($idCategories as $idCategory) {
            $this->touchFacade->touchActive(
                CmsBlockCategoryConnectorConfig::RESOURCE_TYPE_CMS_BLOCK_CATEGORY_CONNECTOR,
                $idCategory
            );
        }

        $this->touchFacade->touchActive(
            CmsBlockCategoryConnectorConfig::RESOURCE_TYPE_CMS_BLOCK_CATEGORY_POSITION,
            $idCmsBlockCategoryPosition
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CmsBlockTransfer $cmsBlockTransfer
     *
     * @return void
     */
    protected function updateCmsBlockCategoryRelationsTransaction(CmsBlockTransfer $cmsBlockTransfer)
    {
        $this->deleteCmsBlockConnectorRelations($cmsBlockTransfer);
        $this->createCmsBlockConnectorRelations($cmsBlockTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CmsBlockTransfer $cmsBlockTransfer
     *
     * @return void
     */
    protected function deleteCmsBlockConnectorRelations(CmsBlockTransfer $cmsBlockTransfer)
    {
        $cmsBlockTransfer->requireIdCmsBlock();

        $query = $this->queryContainer
            ->queryCmsBlockCategoryConnectorByIdCmsBlock($cmsBlockTransfer->getIdCmsBlock());

        $this->deleteRelations($query);
        $this->touchDeleteCategoryCmsBlockRelation($query);
    }

    /**
     * @param SpyCmsBlockCategoryConnectorQuery $query
     *
     * @return void
     */
    protected function deleteRelations(SpyCmsBlockCategoryConnectorQuery $query)
    {
        foreach ($query->find() as $relation) {
            $relation->delete();
        }
    }

    /**
     * @param array $idCmsBlocks
     * @param array $idCategories
     * @param int $idCmsBlockCategoryPosition
     *
     * @return void
     */
    protected function createRelations(array $idCmsBlocks, array $idCategories, $idCmsBlockCategoryPosition)
    {
        foreach ($idCategories as $idCategory) {
            $spyCategory = $this->getCategoryById($idCategory);

            foreach ($idCmsBlocks as $idCmsBlock) {
                $this->createRelation(
                    $idCmsBlock,
                    $idCategory,
                    $idCmsBlockCategoryPosition,
                    $spyCategory->getFkCategoryTemplate()
                );
            }
        }
    }

    /**
     * @param int $idCmsBlock
     * @param int $idCategory
     * @param int $idCmsBlockCategoryPosition
     * @param int $idCategoryTemplate
     *
     * @return void
     */
    protected function createRelation($idCmsBlock, $idCategory, $idCmsBlockCategoryPosition, $idCategoryTemplate)
    {
        $spyCmsBlockConnector = $this->createaBlockCategoryConnectorEntity();
        $spyCmsBlockConnector
            ->setFkCmsBlock($idCmsBlock)
            ->setFkCategory($idCategory)
            ->setFkCmsBlockCategoryPosition($idCmsBlockCategoryPosition)
            ->setFkCategoryTemplate($idCategoryTemplate)
            ->save();
    }

    /**
     * @param int $idCategory
     *
     * @return \Orm\Zed\Category\Persistence\SpyCategory
     */
    protected function getCategoryById($idCategory)
    {
        return $this->categoryQueryContainer
            ->queryCategoryById($idCategory)
            ->findOne();
    }


    /**
     * @param \Generated\Shared\Transfer\CmsBlockTransfer $cmsBlockTransfer
     *
     * @return void
     */
    protected function createCmsBlockConnectorRelations(CmsBlockTransfer $cmsBlockTransfer)
    {
        $cmsBlockTransfer->requireIdCmsBlock();

        foreach ($cmsBlockTransfer->getIdCategories() as $idCmsBlockCategoryPosition => $idCategories) {
            $this->createRelations([$cmsBlockTransfer->getIdCmsBlock()], $idCategories, $idCmsBlockCategoryPosition);
            $this->touchActiveCategoryCmsBlockRelation($idCategories, $idCmsBlockCategoryPosition);
        }
    }

    /**
     * @return \Orm\Zed\CmsBlockCategoryConnector\Persistence\SpyCmsBlockCategoryConnector
     */
    protected function createaBlockCategoryConnectorEntity()
    {
        return new SpyCmsBlockCategoryConnector();
    }

}
