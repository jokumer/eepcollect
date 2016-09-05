<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,pages';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array('LLL:EXT:eepcollect/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1', $_EXTKEY.'_pi1'),'list_type');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_eepcollect_sessions');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_eepcollect_sessions');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_eepcollect_sessions','EXT:eepcollect/Resources/Private/Language/locallang_csh_eepcollect.xlf');

	// add FlexForm field to tt_content
$TCA["tt_content"]["types"]["list"]["subtypes_addlist"][$_EXTKEY."_pi1"]="pi_flexform";

	// add tt_news flexform to tt_content
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($_EXTKEY."_pi1", "FILE:EXT:eepcollect/flexform_ds_pi1.xml");

	// Add the static template for the default setup
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY,'static/','PageCollector Default');
