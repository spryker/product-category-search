<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PersistentCartShare;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class PersistentCartShareConfig extends AbstractBundleConfig
{
    public const RESOURCE_TYPE_QUOTE = 'quote';

    public const SHARE_OPTION_PREVIEW = 'PREVIEW';

    /**
     * @see \Spryker\Shared\SharedCart\SharedCartConfig::PERMISSION_GROUP_FULL_ACCESS
     */
    public const SHARE_OPTION_FULL_ACCESS = 'FULL_ACCESS';

    /**
     * @see \Spryker\Shared\SharedCart\SharedCartConfig::PERMISSION_GROUP_READ_ONLY
     */
    public const SHARE_OPTION_READ_ONLY = 'READ_ONLY';

    public const KEY_ID_QUOTE = 'id_quote';
    public const KEY_SHARE_OPTION = 'share_option';
}
