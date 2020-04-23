<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\Kernel\CodeBucket\Config;

use Spryker\Shared\Kernel\Store;

class DefaultCodeBucketConfig extends AbstractCodeBucketConfig
{
    /**
     * @var bool
     */
    protected $isDynamicStoreMode;

    /**
     * @param bool|null $isDynamicStoreMode
     */
    public function __construct(?bool $isDynamicStoreMode = null)
    {
        $this->isDynamicStoreMode = $isDynamicStoreMode ?? Store::isDynamicStoreMode();
    }

    /**
     * @return string[]
     */
    public function getCodeBuckets(): array
    {
        if (!$this->isDynamicStoreMode) {
            return Store::getInstance()->getAllowedStores();
        }

        return [];
    }

    /**
     * @return string
     */
    public function getCurrentCodeBucket(): string
    {
        if (!$this->isDynamicStoreMode) {
            return Store::getInstance()->getStoreName();
        }

        return '';
    }
}
