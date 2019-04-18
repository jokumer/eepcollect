<?php
defined('TYPO3_MODE') || die();

// Add plugin
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43(
    'eepcollect',
    '',
    '_pi1',
    'list_type',
    0
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'LLL:EXT:eepcollect/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1',
        'eepcollect_pi1'
    ],
    'list_type',
    'eepcollect'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['eepcollect_pi1'] = 'layout,select_key,pages';

// Add flexform to tt_content
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'eepcollect_pi1',
    'FILE:EXT:eepcollect/Configuration/Flexform/flexform.xml'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['eepcollect_pi1'] = 'pi_flexform';
