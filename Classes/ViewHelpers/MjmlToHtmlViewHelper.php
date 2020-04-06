<?php
declare(strict_types = 1);

namespace Ssch\Typo3Mjml\ViewHelpers;

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

use Ssch\Typo3Mjml\Renderer\RendererFactoryInterface;
use Ssch\Typo3Mjml\Renderer\RendererInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * @final
 */
class MjmlToHtmlViewHelper extends AbstractViewHelper
{
    /**
     * @var bool
     */
    protected $escapeChildren = false;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * @var RendererInterface
     */
    private $renderer;

    public function injectRendererFactory(RendererFactoryInterface $rendererFactory): void
    {
        $this->renderer = $rendererFactory->create();
    }

    public function render(): string
    {
        return $this->renderer->render($this->renderChildren());
    }
}
