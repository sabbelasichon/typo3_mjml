<?php
declare(strict_types = 1);

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

use Ssch\Typo3Mjml\Integration\JsonEncoder;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * @covers \Ssch\Typo3Mjml\Integration\JsonEncoder
 */
final class JsonEncoderTest extends UnitTestCase
{
    /**
     * @test
     */
    public function encode(): void
    {
        $data = ['name' => 'Max'];
        $encoder = new JsonEncoder();
        $this->assertEquals('{"name":"Max"}', $encoder->encode($data));
    }
}
