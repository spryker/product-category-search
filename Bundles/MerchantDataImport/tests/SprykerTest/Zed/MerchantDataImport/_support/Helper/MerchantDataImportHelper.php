<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerTest\Zed\MerchantDataImport\Helper;

use Codeception\Module;
use Orm\Zed\Merchant\Persistence\SpyMerchant;
use Orm\Zed\Merchant\Persistence\SpyMerchantQuery;
use SprykerTest\Shared\Testify\Helper\LocatorHelperTrait;

class MerchantDataImportHelper extends Module
{
    use LocatorHelperTrait;

    /**
     * @param string[] $references
     *
     * @return void
     */
    public function assertDatabaseTableContainsData(array $references): void
    {
        $query = $this->getMerchantQuery()->filterByMerchantReference_In($references);
        $this->assertTrue($query->count() > 0, 'Expected at least one entry in the database table but database table is empty.');
    }

    /**
     * @return \Orm\Zed\Merchant\Persistence\SpyMerchantQuery
     */
    protected function getMerchantQuery(): SpyMerchantQuery
    {
        return SpyMerchantQuery::create();
    }

    /**
     * @param string $key
     *
     * @return \Orm\Zed\Merchant\Persistence\SpyMerchant|null
     */
    public function findMerchantByKey(string $key): ?SpyMerchant
    {
        return $this->getMerchantQuery()
            ->filterByMerchantKey($key)
            ->findOne();
    }
}
