<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'MJML for TYPO3',
    'description' => 'MJML for TYPO3',
    'category' => 'fe',
    'author' => 'Sebastian Schreiber',
    'author_email' => 'breakpoint@schreibersebastian.de',
    'state' => 'stable',
    'clearCacheOnLoad' => false,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'php' => '7.2.5-7.4.999',
            'typo3' => '9.5.0-10.3.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
