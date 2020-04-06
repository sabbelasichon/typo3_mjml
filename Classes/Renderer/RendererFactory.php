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

use Ssch\Typo3Mjml\Integration\JsonDecoder;
use Ssch\Typo3Mjml\Integration\JsonEncoder;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

final class RendererFactory implements RendererFactoryInterface
{
    /**
     * @var ExtensionConfiguration
     */
    private $extensionConfiguration;

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    public function __construct(ExtensionConfiguration $extensionConfiguration)
    {
        $this->extensionConfiguration = $extensionConfiguration;
    }

    public function create(): RendererInterface
    {
        try {
            $configuration = $this->extensionConfiguration->get('typo3_mjml');
        } catch (ExtensionConfigurationExtensionNotConfiguredException | ExtensionConfigurationPathDoesNotExistException $e) {
            $configuration = [
                'type' => 'binary',
                'binary_path' => '/usr/bin/node ./node_modules/mjml/bin/'
            ];
        }

        if ((string)$configuration['type'] === 'api') {
            return new ApiRenderer((string)$configuration['app_id'], (string)$configuration['secrect_key'], new RequestFactory(), new JsonEncoder(), new JsonDecoder());
        }

        return new BinaryRenderer((string)$configuration['binary_path']);
    }
}
