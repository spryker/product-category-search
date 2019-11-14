<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesMerchantConnector\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\SalesMerchantConnector\Business\Expander\OrderItemExpander;
use Spryker\Zed\SalesMerchantConnector\Business\Expander\OrderItemExpanderInterface;
use Spryker\Zed\SalesMerchantConnector\Business\SalesOrderMerchantWriter\SalesOrderMerchantWriter;
use Spryker\Zed\SalesMerchantConnector\Business\SalesOrderMerchantWriter\SalesOrderMerchantWriterInterface;

/**
 * @method \Spryker\Zed\SalesMerchantConnector\SalesMerchantConnectorConfig getConfig()
 * @method \Spryker\Zed\SalesMerchantConnector\Persistence\SalesMerchantConnectorEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\SalesMerchantConnector\Persistence\SalesMerchantConnectorRepositoryInterface getRepository()
 */
class SalesMerchantConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\SalesMerchantConnector\Business\Expander\OrderItemExpanderInterface
     */
    public function createOrderItemExpander(): OrderItemExpanderInterface
    {
        return new OrderItemExpander();
    }

    /**
     * @return \Spryker\Zed\SalesMerchantConnector\Business\SalesOrderMerchantWriter\SalesOrderMerchantWriterInterface
     */
    public function createSalesOrderMerchantWriter(): SalesOrderMerchantWriterInterface
    {
        return new SalesOrderMerchantWriter(
            $this->getEntityManager(),
            $this->getRepository()
        );
    }
}
