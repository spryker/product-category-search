<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CartCodesRestApi\Business;

use Spryker\Zed\CartCodesRestApi\Business\CartCodeAdder\CartCodeAdder;
use Spryker\Zed\CartCodesRestApi\Business\CartCodeAdder\CartCodeAdderInterface;
use Spryker\Zed\CartCodesRestApi\CartCodesRestApiDependencyProvider;
use Spryker\Zed\CartCodesRestApi\Dependency\Facade\CartCodesRestApiToCartCodeFacadeInterface;
use Spryker\Zed\CartCodesRestApi\Dependency\Facade\CartCodesRestApiToQuoteFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Spryker\Zed\CartCodesRestApi\CartCodesRestApiConfig getConfig()
 */
class CartCodesRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return CartCodeAdderInterface
     */
    public function createCartCodeAdder(): CartCodeAdderInterface
    {
        return new CartCodeAdder(
            $this->getCartCodeFacade(),
            $this->getQuoteFacade()
        );
    }

    /**
     * @return CartCodesRestApiToCartCodeFacadeInterface
     */
    public function getCartCodeFacade(): CartCodesRestApiToCartCodeFacadeInterface
    {
        return $this->getProvidedDependency(CartCodesRestApiDependencyProvider::FACADE_CART_CODE);
    }

    /**
     * @return CartCodesRestApiToQuoteFacadeInterface
     */
    public function getQuoteFacade(): CartCodesRestApiToQuoteFacadeInterface
    {
        return $this->getProvidedDependency(CartCodesRestApiDependencyProvider::FACADE_QUOTE);
    }
}
