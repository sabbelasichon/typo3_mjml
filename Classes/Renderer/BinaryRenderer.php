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
use TYPO3\CMS\Core\Utility\CommandUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class BinaryRenderer implements RendererInterface
{

    /**
     * @var string
     */
    private $bin;

    public function __construct(string $bin)
    {
        $this->bin = trim($bin);
    }

    public function render(string $content): string
    {
        $temporaryFile = GeneralUtility::tempnam('mjml_', '.mjml');

        GeneralUtility::writeFileToTypo3tempDir($temporaryFile, $content);

        $cmd = $this->bin;
        $args = $temporaryFile.' '.'-s --config.beautify true --config.minify true';

        $result = [];
        $returnValue = '';

        CommandUtility::exec($this->getEscapedCommand($cmd, $args), $result, $returnValue);

        GeneralUtility::unlink_tempfile($temporaryFile);

        return implode('', $result);
    }

    private function getEscapedCommand(string $cmd, string $args): string
    {
        $escapedCmd = escapeshellcmd($cmd);

        $argsArray = explode(' ', $args);
        $escapedArgsArray = CommandUtility::escapeShellArguments($argsArray);
        $escapedArgs = implode(' ', $escapedArgsArray);

        return $escapedCmd.' '.$escapedArgs;
    }
}

