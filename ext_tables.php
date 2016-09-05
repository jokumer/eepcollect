<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_eepcollect_sessions"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:eepcollect/Resources/Private/Language/locallang_db.xlf:tx_eepcollect_sessions',		
		'label'     => 'uid',	
		'default_sortby' => "ORDER BY ses_tstamp",	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_eepcollect_sessions.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "ses_id, feuser_id, ses_tstamp, ses_data",
	)
);

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,pages';

t3lib_extMgm::addPlugin(array('LLL:EXT:eepcollect/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1', $_EXTKEY.'_pi1'),'list_type');

t3lib_extMgm::allowTableOnStandardPages('tx_eepcollect_sessions');
t3lib_extMgm::addToInsertRecords('tx_eepcollect_sessions');
t3lib_extMgm::addLLrefForTCAdescr('tx_eepcollect_sessions','EXT:eepcollect/Resources/Private/Language/locallang_csh_eepcollect.xlf');

	// add FlexForm field to tt_content
$TCA["tt_content"]["types"]["list"]["subtypes_addlist"][$_EXTKEY."_pi1"]="pi_flexform";

	// add tt_news flexform to tt_content
t3lib_extMgm::addPiFlexFormValue($_EXTKEY."_pi1", "FILE:EXT:eepcollect/flexform_ds_pi1.xml");

	// Add the static template for the default setup
t3lib_extMgm::addStaticFile($_EXTKEY,'static/','PageCollector Default');

?>