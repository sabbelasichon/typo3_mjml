<?php

namespace Ssch\Typo3Mjml\Tests\Unit\Integration;

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
use Ssch\Typo3Mjml\Integration\JsonDecoder;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * @covers \Ssch\Typo3Mjml\Integration\JsonDecoder
 */
class JsonDecoderTest extends UnitTestCase
{
    /**
     * @var JsonDecoder
     */
    protected $subject;

    protected function setUp(): void
    {
        $this->subject = new JsonDecoder();
    }

    /**
     * @test
     */
    public function decode(): void
    {
        $json = '{"name": "Max"}';
        $this->assertEquals(['name' => 'Max'], $this->subject->decode($json));
    }

    /**
     * @test
     */
    public function decodeThrowsException(): void
    {
        $this->expectException(RuntimeException::class);
        $json = '{name: "Max"}';
        $this->subject->decode($json);
    }
}
