<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductListGui\Communication;

use Generated\Shared\Transfer\ProductListTransfer;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\ProductListGui\Communication\DataProvider\CategoryDataProvider;
use Spryker\Zed\ProductListGui\Communication\DataProvider\ProductListDataProvider;
use Spryker\Zed\ProductListGui\Communication\DataProvider\ProductListProductConcreteRelationDataProvider;
use Spryker\Zed\ProductListGui\Communication\DataTransformer\CsvToProductsConcreteTransformer;
use Spryker\Zed\ProductListGui\Communication\Form\ProductListForm;
use Spryker\Zed\ProductListGui\Communication\Table\ProductConcreteTable;
use Spryker\Zed\ProductListGui\Communication\Table\ProductListTable;
use Spryker\Zed\ProductListGui\Communication\Tabs\AssignedProductConcreteTabs;
use Spryker\Zed\ProductListGui\Communication\Tabs\ProductConcreteTabs;
use Spryker\Zed\ProductListGui\Communication\Tabs\ProductListTabs;
use Spryker\Zed\ProductListGui\Dependency\Facade\ProductListGuiToLocaleFacadeInterface;
use Spryker\Zed\ProductListGui\Dependency\Facade\ProductListGuiToProductListFacadeInterface;
use Spryker\Zed\ProductListGui\Dependency\Service\ProductListGuiToUtilCsvServiceInterface;
use Spryker\Zed\ProductListGui\ProductListGuiDependencyProvider;
use Symfony\Component\Form\FormInterface;

/**
 * @method \Spryker\Zed\ProductListGui\Business\ProductListGuiFacadeInterface getFacade();
 * @method \Spryker\Zed\ProductListGui\ProductListGuiConfig getConfig()
 * @method \Spryker\Zed\ProductListGui\Persistence\ProductListGuiRepositoryInterface getRepository()
 */
class ProductListGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Spryker\Zed\ProductListGui\Communication\Table\ProductListTable
     */
    public function createProductListTable(): ProductListTable
    {
        return new ProductListTable();
    }

    /**
     * @param \Generated\Shared\Transfer\ProductListTransfer|null $productListTransfer
     * @param bool $notInList
     *
     * @return \Spryker\Zed\ProductListGui\Communication\Table\ProductConcreteTable
     */
    public function createProductConcreteTable(
        ?ProductListTransfer $productListTransfer = null,
        bool $notInList = true
    ): ProductConcreteTable {
        $locale = $this->getLocaleFacade()->getCurrentLocale();

        return new ProductConcreteTable($locale, $productListTransfer, $notInList);
    }

    /**
     * @return \Spryker\Zed\ProductListGui\Communication\Tabs\ProductListTabs
     */
    public function createProductListTabs(): ProductListTabs
    {
        return new ProductListTabs();
    }

    /**
     * @return \Spryker\Zed\ProductListGui\Communication\Tabs\ProductConcreteTabs
     */
    public function createProductConcreteTabs(): ProductConcreteTabs
    {
        return new ProductConcreteTabs();
    }

    /**
     * @return \Spryker\Zed\ProductListGui\Communication\Tabs\AssignedProductConcreteTabs
     */
    public function createAssignedProductConcreteTabs(): AssignedProductConcreteTabs
    {
        return new AssignedProductConcreteTabs();
    }

    /**
     * @param \Generated\Shared\Transfer\ProductListTransfer|null $productListTransfer
     *
     * @return \Spryker\Zed\ProductListGui\Communication\Form\ProductListForm|\Symfony\Component\Form\FormInterface
     */
    public function getProductListForm(?ProductListTransfer $productListTransfer = null): FormInterface
    {
        $dataProvider = $this->createProductListDataProvider();

        return $this->getFormFactory()->create(
            ProductListForm::class,
            $dataProvider->getData($productListTransfer),
            $dataProvider->getOptions($productListTransfer)
        );
    }

    /**
     * @return \Spryker\Zed\ProductListGui\Communication\DataProvider\ProductListDataProvider
     */
    public function createProductListDataProvider(): ProductListDataProvider
    {
        return new ProductListDataProvider(
            $this->createCategoriesDataProvider(),
            $this->createProductConcreteDataProvider(),
            ...$this->getProductListCreateFormExpanderPlugins()
        );
    }

    /**
     * @return \Spryker\Zed\ProductListGui\Communication\DataProvider\CategoryDataProvider
     */
    public function createCategoriesDataProvider(): CategoryDataProvider
    {
        return new CategoryDataProvider(
            $this->getFacade()
        );
    }

    /**
     * @return \Spryker\Zed\ProductListGui\Communication\DataProvider\ProductListProductConcreteRelationDataProvider
     */
    public function createProductConcreteDataProvider(): ProductListProductConcreteRelationDataProvider
    {
        return new ProductListProductConcreteRelationDataProvider(
            $this->getFacade()
        );
    }

    /**
     * @return \Spryker\Zed\ProductListGui\Communication\DataTransformer\CsvToProductsConcreteTransformer
     */
    public function createCsvToProductsConcreteTransformer(): CsvToProductsConcreteTransformer
    {
        return new CsvToProductsConcreteTransformer(
            $this->getUtilCsvService(),
            $this->getRepository()
        );
    }

    /**
     * @return \Spryker\Zed\ProductListGui\Dependency\Facade\ProductListGuiToProductListFacadeInterface
     */
    public function getProductListFacade(): ProductListGuiToProductListFacadeInterface
    {
        return $this->getProvidedDependency(ProductListGuiDependencyProvider::FACADE_PRODUCT_LIST);
    }

    /**
     * @return \Spryker\Zed\ProductListGuiExtension\Dependency\Plugin\ProductListCreateFormExpanderPluginInterface[]
     */
    public function getProductListCreateFormExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ProductListGuiDependencyProvider::PLUGINS_FORM_EXTENSION);
    }

    /**
     * @return \Spryker\Zed\ProductListGui\Dependency\Facade\ProductListGuiToLocaleFacadeInterface
     */
    public function getLocaleFacade(): ProductListGuiToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(ProductListGuiDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return \Spryker\Zed\ProductListGui\Dependency\Service\ProductListGuiToUtilCsvServiceInterface
     */
    public function getUtilCsvService(): ProductListGuiToUtilCsvServiceInterface
    {
        return $this->getProvidedDependency(ProductListGuiDependencyProvider::SERVICE_UTIL_CSV);
    }
}
