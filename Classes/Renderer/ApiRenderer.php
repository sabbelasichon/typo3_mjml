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
use TYPO3\CMS\Core\Http\RequestFactory;

final class ApiRenderer implements RendererInterface
{
    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $secretKey;

    /**
     * @var string
     */
    private const BASE_URI = 'https://api.mjml.io/v1/';

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * @var JsonEncoder
     */
    private $jsonEncoder;

    /**
     * @var JsonDecoder
     */
    private $jsonDecoder;

    public function __construct(string $appId, string $secretKey, RequestFactory $requestFactory, JsonEncoder $jsonEncoder, JsonDecoder $jsonDecoder)
    {
        $this->appId = $appId;
        $this->secretKey = $secretKey;
        $this->requestFactory = $requestFactory;
        $this->jsonEncoder = $jsonEncoder;
        $this->jsonDecoder = $jsonDecoder;
    }

    public function render(string $content): string
    {
        $response = $this->requestFactory->request(
            sprintf('%s%s', self::BASE_URI, 'render'),
            'POST',
            [
                'auth' => [$this->appId, $this->secretKey],
                'body' => $this->jsonEncoder->encode([
                    'mjml' => $content,
                ]),
            ]
        );

        $data = $this->jsonDecoder->decode($response->getBody()->getContents());

        return $data['html'];
    }
}
