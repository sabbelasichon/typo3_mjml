<?php

namespace Ssch\Typo3Mjml\Tests\Unit\Renderer;

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

use RuntimeException;
use Ssch\Typo3Mjml\Renderer\BinaryRenderer;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * @covers \Ssch\Typo3Mjml\Renderer\BinaryRenderer
 */
class BinaryRendererTest extends UnitTestCase
{
    /**
     * @test
     */
    public function renderSuccessfully(): void
    {
        $binaryRenderer = new BinaryRenderer(__DIR__ . '/Fixtures/mjml.sh');
        $this->assertStringContainsString('html', $binaryRenderer->render('<mjml></mjml>'));
    }
}
