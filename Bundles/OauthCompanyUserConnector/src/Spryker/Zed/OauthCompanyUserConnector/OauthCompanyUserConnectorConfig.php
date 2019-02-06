<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\OauthCompanyUserConnector;

use Spryker\Shared\OauthCompanyUserConnector\OauthCompanyUserConnectorConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class OauthCompanyUserConnectorConfig extends AbstractBundleConfig
{
    public const SCOPE_COMPANY_USER = 'company_user';

    /**
     * @uses \Spryker\Zed\OauthCustomerConnector\OauthCustomerConnectorConfig::SCOPE_CUSTOMER
     */
    public const SCOPE_CUSTOMER = 'customer';

    /**
     * @uses \Spryker\Zed\Oauth\OauthConfig::GRANT_TYPE_USER
     */
    public const GRANT_TYPE_USER = 'user';

    /**
     * The client secret used to authenticate Oauth client requests, to create use "password_hash('your password', PASSWORD_BCRYPT)".
     *
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->get(OauthCompanyUserConnectorConstants::OAUTH_CLIENT_SECRET);
    }

    /**
     * The client id as is store in spy_oauth_client database table
     *
     * @return string
     */
    public function getClientId(): string
    {
        return $this->get(OauthCompanyUserConnectorConstants::OAUTH_CLIENT_IDENTIFIER);
    }

    /**
     * @return array
     */
    public function getCompanyUserScopes(): array
    {
        return [
            static::SCOPE_CUSTOMER,
            static::SCOPE_COMPANY_USER,
        ];
    }
}
