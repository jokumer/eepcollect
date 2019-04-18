<?php
defined('TYPO3_MODE') || die();

// Add the static template for the default setup
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'eepcollect',
    'Configuration/TypoScript',
    'PageCollector Default'
);
