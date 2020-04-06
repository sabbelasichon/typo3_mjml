<?php
declare(strict_types=1);


namespace Ssch\Typo3Mjml\Tests\Functional;

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

use Doctrine\DBAL\DBALException;
use TYPO3\TestingFramework\Core\Exception;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequestContext;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class ConvertMjmlToHtmlTest extends FunctionalTestCase
{
    private const ROOT_PAGE_UID = 1;

    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/typo3_mjml',
    ];

    /**
     * @var string[]
     */
    protected $coreExtensionsToLoad = ['fluid'];

    /**
     * @var array
     */
    protected $configurationToUseInTestInstance = [
        'EXTENSIONS' => [
            'typo3_mjml' => [
                'type' => 'binary',
                'binary_path' => 'mjml'
            ],
        ],
    ];


    /**
     * @throws DBALException
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->importDataSet(__DIR__ . '/Fixtures/Database/pages.xml');
        $this->setUpFrontendRootPage(1, ['EXT:typo3_mjml/Tests/Functional/Fixtures/Frontend/Basic.typoscript']);
    }

    /**
     * @test
     */
    public function convertToHtml(): void
    {
        $result = $this->retrieveFrontendRequestResult(
            (new InternalRequest())->withPageId(self::ROOT_PAGE_UID),
            (new InternalRequestContext()),
            false
        );
        $response = $this->reconstituteFrontendRequestResult($result);

        $this->assertStringContainsString($response->getBody()->getContents(),file_get_contents( __DIR__ . '/Fixtures/converted.html'));
    }
}
