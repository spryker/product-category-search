<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Touch\Business;

use Spryker\Zed\Touch\Business\Model\Touch;
use Spryker\Zed\Touch\Business\Model\TouchRecord;
use Spryker\Zed\Kernel\Business\AbstractBusinessDependencyContainer;
use Spryker\Zed\Touch\Business\Model\TouchInterface;
use Spryker\Zed\Touch\Business\Model\TouchRecordInterface;
use Spryker\Zed\Touch\Persistence\TouchQueryContainerInterface;
use Spryker\Zed\Touch\TouchDependencyProvider;

class TouchDependencyContainer extends AbstractBusinessDependencyContainer
{

    /**
     * @return TouchRecordInterface
     */
    public function getTouchRecordModel()
    {
        return new TouchRecord(
            $this->getQueryContainer(),
            $this->getProvidedDependency(TouchDependencyProvider::PLUGIN_PROPEL_CONNECTION)
        );
    }

    /**
     * @return TouchInterface
     */
    public function getTouchModel()
    {
        return new Touch(
            $this->getQueryContainer(),
            $this->getProvidedDependency(TouchDependencyProvider::PLUGIN_PROPEL_CONNECTION)
        );
    }

    /**
     * @return TouchQueryContainerInterface
     */
    protected function getQueryContainer()
    {
        return $this->getLocator()->touch()->queryContainer();
    }

}
