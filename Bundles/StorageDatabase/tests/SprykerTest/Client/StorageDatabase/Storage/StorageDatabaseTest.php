<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Client\StorageDatabase\Storage;

use Codeception\Test\Unit;
use ReflectionClass;
use Spryker\Client\StorageDatabase\Storage\Reader\AbstractStorageReader;
use Spryker\Client\StorageDatabase\Storage\StorageDatabase;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Client
 * @group StorageDatabase
 * @group Storage
 * @group StorageDatabaseTest
 * Add your own group annotations below this line
 */
class StorageDatabaseTest extends Unit
{
    protected const DUMMY_SINGLE_KEY = 'dummy_key';

    /**
     * @var \Spryker\Client\StorageDatabase\Storage\Reader\AbstractStorageReader|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storageReaderMock;

    /**
     * @var \Spryker\Client\StorageDatabase\Storage\StorageDatabaseInterface
     */
    protected $storageDatabase;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->setupStorageReaderMock();
        $this->setupStorageDatabase();
    }

    /**
     * @return void
     */
    public function testGetReadsFromStorage(): void
    {
        $dummyKey = 'dummy_key';

        $this->storageReaderMock
            ->expects($this->once())
            ->method('get')
            ->with($dummyKey);

        $this->storageDatabase->get($dummyKey);
    }

    /**
     * @dataProvider getReturnsDecodedResultWhenPresentProvider
     *
     * @param string $storageReaderReturnValue
     * @param mixed $expectedResult
     *
     * @return void
     */
    public function testGetReturnsDecodedResultWhenPresent(string $storageReaderReturnValue, $expectedResult): void
    {
        $this->storageReaderMock
            ->method('get')
            ->willReturn($storageReaderReturnValue);

        $result = $this->storageDatabase->get('dummy_key');
        $this->assertNotEmpty($result);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function getReturnsDecodedResultWhenPresentProvider(): array
    {
        return [
            ['"dummy_value"', 'dummy_value'],
            ['["dummy_value"]', ['dummy_value']],
            ['{"dummy_key": "dummy_value"}', ['dummy_key' => 'dummy_value']],
        ];
    }

    /**
     * @return void
     */
    public function testGetReturnsNullWhenEmptyResult(): void
    {
        $this->storageReaderMock
            ->method('get')
            ->willReturn('');

        $this->assertNull($this->storageDatabase->get('dummy_key'));
    }

    /**
     * @return void
     */
    public function testGetMultiReturnsEmptyArrayWhenNoKeys(): void
    {
        $result = $this->storageDatabase->getMulti([]);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * @return void
     */
    public function testGetMultiReturnsResultWithPrefixedKeys(): void
    {
        $this->storageReaderMock
            ->method('getMulti')
            ->willReturn(
                $this->getMultiResult()
            );

        $this->assertEquals($this->getMultiResultWithPrefixedKeys(), $this->storageDatabase->getMulti(['key1', 'key2']));
    }

    /**
     * @return array
     */
    public function testAddsReadAccessStatsForGetWhenDebugEnabled(): array
    {
        $this->storageDatabase->setDebug(true);

        $this->storageDatabase->get('dummy_key');
        $accessStats = $this->storageDatabase->getAccessStats();

        $this->assertEquals(1, $accessStats['count']['read']);
        $this->assertCount(1, $accessStats['keys']['read']);
        $this->assertEquals('dummy_key', $accessStats['keys']['read'][0]);

        return $accessStats;
    }

    /**
     * @depends testAddsReadAccessStatsForGetWhenDebugEnabled
     *
     * @param array $accessStats
     *
     * @return void
     */
    public function testCanResetAccessStats(array $accessStats): void
    {
        $this->setAccessStats($accessStats);
        $this->assertEquals($accessStats, $this->storageDatabase->getAccessStats());

        $this->storageDatabase->resetAccessStats();
        $this->assertEquals($this->getEmptyAccessStats(), $this->storageDatabase->getAccessStats());
    }

    /**
     * @return void
     */
    public function testDoesntAddReadAccessStatsForGetWhenDebugDisabled(): void
    {
        $this->storageDatabase->setDebug(false);

        $this->storageDatabase->get('dummy_key');
        $accessStats = $this->storageDatabase->getAccessStats();

        $this->assertEquals($this->getEmptyAccessStats(), $accessStats);
    }

    /**
     * @return array
     */
    protected function getMultiResultWithPrefixedKeys(): array
    {
        $multiResult = $this->getMultiResult();
        $prefixedKeys = [];

        foreach (array_keys($multiResult) as $key) {
            $prefixedKeys[] = sprintf('kv:%s', $key);
        }

        return array_combine($prefixedKeys, $multiResult);
    }

    /**
     * @return array
     */
    protected function getMultiResult(): array
    {
        return [
            'key1' => 'value1',
            'key2' => 'value2',
        ];
    }

    /**
     * @return void
     */
    protected function setupStorageReaderMock(): void
    {
        $this->storageReaderMock = $this->createMock(AbstractStorageReader::class);
    }

    /**
     * @param array $accessStats
     *
     * @return void
     */
    protected function setAccessStats(array $accessStats): void
    {
        $storageDatabaseReflection = new ReflectionClass(StorageDatabase::class);
        $accessStatsReflection = $storageDatabaseReflection->getProperty('accessStats');
        $accessStatsReflection->setAccessible(true);
        $accessStatsReflection->setValue($this->storageDatabase, $accessStats);
    }

    /**
     * @return array
     */
    protected function getEmptyAccessStats(): array
    {
        return [
            'count' => [
                'read' => 0,
            ],
            'keys' => [
                'read' => [],
            ],
        ];
    }

    /**
     * @return void
     */
    protected function setupStorageDatabase(): void
    {
        $this->storageDatabase = new StorageDatabase(
            $this->storageReaderMock
        );
    }
}
