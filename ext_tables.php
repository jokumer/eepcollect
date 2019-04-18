<?php
defined('TYPO3_MODE') || die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_eepcollect_sessions');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_eepcollect_sessions');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tx_eepcollect_sessions',
    'EXT:eepcollect/Resources/Private/Language/locallang_csh_eepcollect.xlf'
);
