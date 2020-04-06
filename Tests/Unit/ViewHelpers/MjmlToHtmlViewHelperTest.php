<?php

namespace Ssch\Typo3Mjml\Tests\Unit\ViewHelpers;

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

use PHPUnit\Framework\MockObject\MockObject;
use Prophecy\Prophecy\ObjectProphecy;
use Ssch\Typo3Mjml\Renderer\RendererFactoryInterface;
use Ssch\Typo3Mjml\Renderer\RendererInterface;
use Ssch\Typo3Mjml\ViewHelpers\MjmlToHtmlViewHelper;
use TYPO3\TestingFramework\Fluid\Unit\ViewHelpers\ViewHelperBaseTestcase;

/**
 * @covers \Ssch\Typo3Mjml\ViewHelpers\MjmlToHtmlViewHelper
 */
class MjmlToHtmlViewHelperTest extends ViewHelperBaseTestcase
{
    /**
     * @var MjmlToHtmlViewHelper|MockObject
     */
    protected $viewHelper;

    /**
     * @var ObjectProphecy|RendererInterface
     */
    protected $renderer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->renderer = $this->prophesize(RendererInterface::class);
        $rendererFactory = $this->prophesize(RendererFactoryInterface::class);
        $rendererFactory->create()->shouldBeCalledOnce()->willReturn($this->renderer);
        $this->viewHelper = $this->createPartialMock(MjmlToHtmlViewHelper::class, ['renderChildren']);
        $this->viewHelper->injectRendererFactory($rendererFactory->reveal());
    }

    /**
     * @test
     */
    public function render(): void
    {
        $content = '<mjml></mjml>';
        $this->viewHelper->expects($this->once())->method('renderChildren')->willReturn($content);
        $this->renderer->render($content)->shouldBeCalledOnce()->willReturn('html');
        $this->assertEquals('html', $this->viewHelper->render());
    }
}
