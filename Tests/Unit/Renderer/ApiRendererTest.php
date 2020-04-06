<?php

namespace Ssch\Typo3Mjml\Tests\Unit\Renderer;

use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;
use Ssch\Typo3Mjml\Integration\JsonDecoder;
use Ssch\Typo3Mjml\Integration\JsonEncoder;
use Ssch\Typo3Mjml\Renderer\ApiRenderer;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

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

/**
 * @covers \Ssch\Typo3Mjml\Renderer\ApiRenderer
 */
class ApiRendererTest extends UnitTestCase
{
    private const APP_ID = '123';
    private const SECRET_KEY = '123';

    /**
     * @var ApiRenderer
     */
    protected $subject;

    /**
     * @var ObjectProphecy|RequestFactory
     */
    protected $requestFactory;

    protected function setUp(): void
    {
        $this->requestFactory = $this->prophesize(RequestFactory::class);
        $this->subject = new ApiRenderer(self::APP_ID, self::SECRET_KEY, $this->requestFactory->reveal(), new JsonEncoder(), new JsonDecoder());
    }

    /**
     * @test
     */
    public function renderSuccessfully(): void
    {
        $content = '<mjml></mjml>';

        $options = [
            'auth' => [self::APP_ID, self::SECRET_KEY],
            'body' => json_encode([
                'mjml' => $content,
            ]),
        ];

        $response = $this->prophesize(ResponseInterface::class);
        $responseBody = $this->prophesize(StreamInterface::class);
        $responseBody->getContents()->willReturn('{"html": "string"}');
        $response->getBody()->willReturn($responseBody);
        $this->requestFactory->request('https://api.mjml.io/v1/render', 'POST', $options)->shouldBeCalled()->willReturn($response);
        $this->assertEquals('string', $this->subject->render($content));
    }

    /**
     * @test
     */
    public function renderThrowsException(): void
    {
        $this->expectException(RuntimeException::class);
        $content = '<mjml></mjml>';

        $options = [
            'auth' => [self::APP_ID, self::SECRET_KEY],
            'body' => json_encode([
                'mjml' => $content,
            ]),
        ];

        $response = $this->prophesize(ResponseInterface::class);
        $responseBody = $this->prophesize(StreamInterface::class);
        $responseBody->getContents()->willReturn('Name: d}');
        $response->getBody()->willReturn($responseBody);
        $this->requestFactory->request('https://api.mjml.io/v1/render', 'POST', $options)->shouldBeCalled()->willReturn($response);
        $this->assertEquals('string', $this->subject->render($content));
    }
}
