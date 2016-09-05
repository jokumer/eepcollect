<?php
return array (
    'ctrl' => array (
        'title'     => 'LLL:EXT:eepcollect/Resources/Private/Language/locallang_db.xlf:tx_eepcollect_sessions',
        'label'     => 'uid',
        'default_sortby' => 'ORDER BY ses_tstamp',
        'iconfile'          => 'EXT:eepcollect/Resources/Public/Icons/tx_eepcollect_sessions.gif',
    ),
    'interface' => array (
        'showRecordFieldList' => 'ses_id,feuser_id,ses_tstamp,ses_data'
    ),
    'columns' => array (
        'ses_id' => Array (
            'exclude' => 1,
            'label' => 'LLL:EXT:eepcollect/Resources/Private/Language/locallang_db.xlf:tx_eepcollect_sessions.ses_id',
            'config' => Array (
                'type' => 'input',
                'size' => '30',
            )
        ),
        'feuser_id' => Array (
            'exclude' => 1,
            'label' => 'LLL:EXT:eepcollect/Resources/Private/Language/locallang_db.xlf:tx_eepcollect_sessions.feuser_id',
            'config' => Array (
                'type' => 'select',
                'items' => Array (
                    Array('LLL:EXT:eepcollect/Resources/Private/Language/locallang_db.xlf:tx_eepcollect_sessions.feuser_id.0', '0'),
                ),
                'foreign_table' => 'fe_users',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0,
            )
        ),
        'ses_tstamp' => Array (
            'exclude' => 1,
            'label' => 'LLL:EXT:eepcollect/Resources/Private/Language/locallang_db.xlf:tx_eepcollect_sessions.ses_tstamp',
            'config' => Array (
                'type' => 'none',
                'size' => '12',
                'max' => '20',
                'eval' => 'datetime',
                'default' => time(),
            )
        ),
        'ses_data' => Array (
            'exclude' => 1,
            'label' => 'LLL:EXT:eepcollect/Resources/Private/Language/locallang_db.xlf:tx_eepcollect_sessions.ses_data',
            'config' => Array (
                'type' => 'input',
                'size' => '30',
            )
        ),
    ),
    'types' => array (
        '0' => array('showitem' => 'ses_id;;;;1-1-1, feuser_id, ses_tstamp, ses_data')
    ),
    'palettes' => array (
        '1' => array('showitem' => '')
    )
);