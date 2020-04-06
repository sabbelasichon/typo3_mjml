<?php
declare(strict_types = 1);

namespace Ssch\Typo3Mjml\Renderer;

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
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class BinaryRenderer implements RendererInterface
{

    /**
     * @var string
     */
    private $bin;

    public function __construct(string $bin)
    {
        $this->bin = $bin;
    }

    public function render(string $content): string
    {
        $arguments = [
            $this->bin,
            '-i',
            '-s',
            '--config.validationLevel',
            '--config.minify',
        ];

        $process = new Process($arguments);
        $process->setInput($content);

        try {
            $process->mustRun();
        } catch (ProcessFailedException $e) {
            throw new RuntimeException('Unable to compile MJML. Stack error: ' . $e->getMessage());
        }

        return $process->getOutput();
    }
}
