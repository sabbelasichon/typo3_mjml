<?php

namespace Ssch\Typo3Mjml\Tests\Unit;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Ssch\Typo3Mjml\Renderer\ApiRenderer;
use Ssch\Typo3Mjml\Renderer\BinaryRenderer;
use Ssch\Typo3Mjml\Renderer\RendererFactory;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * @covers \Ssch\Typo3Mjml\Renderer\RendererFactory
 */
class RendererFactoryTest extends UnitTestCase
{
    /**
     * @test
     */
    public function createApiRenderer(): void
    {
        $configuration = [
            'type' => 'api',
            'app_id' => 123,
            'secrect_key' => 123
        ];

        $extensionConfiguration = $this->prophesize(ExtensionConfiguration::class);

        $extensionConfiguration->get('typo3_mjml')->willReturn($configuration);

        $rendererFactory = new RendererFactory($extensionConfiguration->reveal());
        $renderer = $rendererFactory->create();
        $this->assertInstanceOf(ApiRenderer::class, $renderer);
    }

    /**
     * @test
     */
    public function createBinaryRenderer(): void
    {
        $extensionConfiguration = $this->prophesize(ExtensionConfiguration::class);
        $extensionConfiguration->get('typo3_mjml')->willThrow(ExtensionConfigurationPathDoesNotExistException::class);
        $rendererFactory = new RendererFactory($extensionConfiguration->reveal());
        $renderer = $rendererFactory->create();
        $this->assertInstanceOf(BinaryRenderer::class, $renderer);
    }
}
