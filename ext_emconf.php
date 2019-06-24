<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Pagecollector',
    'description' => 'Visitors can collect pages and add them to their own favorit-list like a basket in a shop. Inclusiv delete and sort functions.',
    'category' => 'plugin',
    'state' => 'stable',
    'uploadfolder' => true,
    'createDirs' => 'uploads/tx_eepcollect',
    'clearCacheOnLoad' => 0,
    'author' => 'J.Kummer',
    'version' => '2.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-9.5.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Jokumer\\Eepcollect\\' => 'Classes',
        ],
    ]
];
