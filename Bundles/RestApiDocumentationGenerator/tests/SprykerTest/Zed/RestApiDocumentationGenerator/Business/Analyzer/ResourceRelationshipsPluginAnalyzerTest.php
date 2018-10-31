<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\RestApiDocumentationGenerator\Business\Analyzer;

use Codeception\Test\Unit;
use Spryker\Glue\GlueApplication\Plugin\Rest\ResourceRelationshipCollectionProviderPlugin;
use Spryker\Glue\GlueApplication\Rest\Collection\ResourceRelationshipCollection;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRelationshipCollectionInterface;
use Spryker\Glue\RestApiDocumentationGeneratorExtension\Dependency\Plugin\ResourceRelationshipCollectionProviderPluginInterface;
use Spryker\Zed\RestApiDocumentationGenerator\Business\Analyzer\ResourceRelationshipsPluginAnalyzer;
use Spryker\Zed\RestApiDocumentationGenerator\Business\Analyzer\ResourceRelationshipsPluginAnalyzerInterface;
use SprykerTest\Zed\RestApiDocumentationGenerator\Business\Stub\Plugin\TestResourceRelationshipPlugin;
use SprykerTest\Zed\RestApiDocumentationGenerator\Business\Stub\Plugin\TestResourceRoutePlugin;
use SprykerTest\Zed\RestApiDocumentationGenerator\Business\Stub\Plugin\TestResourceRouteRelatedPlugin;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Zed
 * @group RestApiDocumentationGenerator
 * @group Business
 * @group Analyzer
 * @group ResourceRelationshipsPluginAnalyzerTest
 * Add your own group annotations below this line
 */
class ResourceRelationshipsPluginAnalyzerTest extends Unit
{
    protected const RELATIONSHIP_VALUE = 'test-resource-with-relationship';
    protected const RESOURCE_NAME = 'test-resource';

    /**
     * @return void
     */
    public function testGetResourceRelationshipsWillReturnRelationshipNameForPluginWithRelationships(): void
    {
        $resourceRelationshipsPluginAnalyzer = $this->createResourceRelationshipsPluginAnalyzer();
        $plugin = new TestResourceRoutePlugin();

        $relationships = $resourceRelationshipsPluginAnalyzer->getResourceRelationshipsForResourceRoutePlugin($plugin);

        $this->assertNotEmpty($relationships);
        $this->assertCount(1, $relationships);
        $this->assertEquals(static::RELATIONSHIP_VALUE, $relationships[0]);
    }

    /**
     * @return void
     */
    public function testGetResourceRelationshipsWillReturnEMptyArrayForPluginWithoutRelationships(): void
    {
        $resourceRelationshipsPluginAnalyzer = $this->createResourceRelationshipsPluginAnalyzer();
        $plugin = new TestResourceRouteRelatedPlugin();

        $relationships = $resourceRelationshipsPluginAnalyzer->getResourceRelationshipsForResourceRoutePlugin($plugin);

        $this->assertEmpty($relationships);
    }

    /**
     * @return \Spryker\Zed\RestApiDocumentationGenerator\Business\Analyzer\ResourceRelationshipsPluginAnalyzerInterface
     */
    protected function createResourceRelationshipsPluginAnalyzer(): ResourceRelationshipsPluginAnalyzerInterface
    {
        return new ResourceRelationshipsPluginAnalyzer($this->getResourceRelationshipCollectionPlugins());
    }

    /**
     * @return \Spryker\Glue\RestApiDocumentationGeneratorExtension\Dependency\Plugin\ResourceRelationshipCollectionProviderPluginInterface[]
     */
    protected function getResourceRelationshipCollectionPlugins(): array
    {
        return [
            $this->getResourceRelationshipCollectionPluginMock(),
        ];
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\RestApiDocumentationGeneratorExtension\Dependency\Plugin\ResourceRelationshipCollectionProviderPluginInterface
     */
    protected function getResourceRelationshipCollectionPluginMock(): ResourceRelationshipCollectionProviderPluginInterface
    {
        $pluginMock = $this->getMockBuilder(ResourceRelationshipCollectionProviderPlugin::class)
            ->setMethods(['getResourceRelationshipCollection'])
            ->getMock();
        $pluginMock->method('getResourceRelationshipCollection')
            ->willReturn($this->createResourceRelationshipCollection());

        return $pluginMock;
    }

    /**
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRelationshipCollectionInterface
     */
    protected function createResourceRelationshipCollection(): ResourceRelationshipCollectionInterface
    {
        $resourceRelationshipCollection = new ResourceRelationshipCollection();
        $resourceRelationshipCollection->addRelationship(
            static::RESOURCE_NAME,
            $this->createTestResourceRelationshipPlugin()
        );

        return $resourceRelationshipCollection;
    }

    /**
     * @return \SprykerTest\Zed\RestApiDocumentationGenerator\Business\Stub\Plugin\TestResourceRelationshipPlugin
     */
    protected function createTestResourceRelationshipPlugin(): TestResourceRelationshipPlugin
    {
        return new TestResourceRelationshipPlugin();
    }
}
