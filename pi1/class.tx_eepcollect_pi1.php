<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008-2015 Joerg Kummer <typo3 et enobe dot de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
* Plugin 'pagecollector' for the 'eepcollect' extension.
*
* @author Joerg Kummer <typo3 et enobe dot de>
* @package TYPO3
* @subpackage tx_eepcollect
*/
class tx_eepcollect_pi1 extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin
{

        // public vars
    public $prefixId = 'tx_eepcollect_pi1'; // Same as class name
    public $scriptRelPath = 'pi1/class.tx_eepcollect_pi1.php'; // Path to this script relative to the extension dir.
    public $extKey = 'eepcollect'; // The extension key.
        // Configuring so caching is not expected. This value means that cHash params will be set.
    public $pi_checkCHash = true;
    public $pi_USER_INT_obj = 0;
    public $keepPIvarsCache = 1;
    public $piVars = array(        // This is the incoming array GET
        'code' => '',            //
        'ctrl' => '',            //
        'pid' => '',            //
        'prozess' => '',        //
    );

        // private vars
        // defined values
    public $hash_length = 6; // The ident-hash is normally 32 characters and should be! But if you are making sites for WAP-devices og other lowbandwidth stuff, you may shorten the length. Never let this value drop below 6. A length of 6 would give you more than 16 mio possibilities.
    public $sessionTable = 'tx_eepcollect_sessions'; // table containing user-sessions

    /**
     * The main method of the PlugIn
     *
     * @param string  $content: The PlugIn content
     * @param array  $conf: The PlugIn configuration
     * @return The  content that is displayed on the website
     */

    public function main($content, $conf)
    {
        $this->conf = $conf;
        $this->pi_setPiVarDefaults();
        $this->pi_loadLL();
            // Init variables and get member data (formatted for HTML-output). If there was an error, display and exit.
        $this->init();
            // if no user given, but collections depends on users (identify_mode = 2)
        if ($this->feuserID == false && $this->identifyMode == '2') {
            #$this->markerArray['COLLECTIONINFO'] = $this->pi_getLL('collectioninfo_nouser');
            return $this->pi_getLL('collectioninfo_nouser');
        }
            // set all markers to fill templatecode
            // view prozess for current page (depend on excludelist)
        if (is_array($this->pidOfExcludedPages) && in_array($this->currPageId, $this->pidOfExcludedPages)) {
            // clear template and marker stuff for 'CURRENTPAGEPROZESS' if excluded
            if ($this->cObj->getSubpart($this->templateCode, '###CURRENTPAGEPROZESSSECTION###')) {
                $this->templateCode = str_replace(($this->cObj->getSubpart($this->templateCode, '###CURRENTPAGEPROZESSSECTION###')), '<!-- no currentpageprozess -->', $this->templateCode);
            }
        } else {
            $currentPageProzess = $this->view_currentPageProzess();
            $this->markerArray['CURRENTPAGEPROZESSIMAGE'] = $this->local_cObj->stdWrap($currentPageProzess['image'], $this->displayConf['currentpageprozessimage_stdWrap.']);
            $this->markerArray['CURRENTPAGEPROZESSTEXT'] = $this->local_cObj->stdWrap($currentPageProzess['text'], $this->displayConf['currentpageprozesstext_stdWrap.']);
            $this->markerArray['CURRENTPAGEPROZESSTITLE'] = $this->local_cObj->stdWrap($currentPageProzess['title'], $this->displayConf['currentpageprozesstitle_stdWrap.']);
        }
            // view results in pagecollector
        if ($this->currentPageCollectorValueArray) {
            // view information about current collection
            $collectionCount = count($this->currentPageCollectorValueArray);
            $this->markerArray['COLLECTIONINFO'] = sprintf($this->local_cObj->stdWrap($this->pi_getLL('collectioninfo'), $this->displayConf['collectioninfo_stdWrap.']), $collectionCount);
                // view HMENU by commasepareted pid's of cuurentPageCollection list (only usefull in viewmode:ListView to get a overview at the beginning of the hole pageContentListing)
            $this->markerArray['COLLECTIONSMARTLIST'] = $this->local_cObj->stdWrap(implode(',', $this->currentPageCollectorValueArray), $this->displayConf['collectionsmartlist_stdWrap.']);
                // view all collected pages in a smart toolbar-list 'VIEWCOLLECTIONTOOLBARLISTSECTION'
            $this->view_pageCollector('VIEWCOLLECTIONTOOLBARLISTSECTION');
                // view all collected pages in a list 'VIEWCOLLECTIONLISTSECTION'
            $this->view_pageCollector('VIEWCOLLECTIONLISTSECTION');
                // view link to get/printout the collection
            $templateflex_pidOfListPageCollect = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'pidOfListPageCollect', 'sDEF');
            $pidOfListPageCollect = $templateflex_pidOfListPageCollect ? $templateflex_pidOfListPageCollect : $this->conf['pidOfListPageCollect'];
            $viewCollectionLink = $this->pi_linkToPage($this->pi_getLL('showFullPageCollection'), $pidOfListPageCollect);
            $this->markerArray['VIEWCOLLECTIONLINK'] = $this->local_cObj->stdWrap($viewCollectionLink, $this->displayConf['viewcollectionlink_stdWrap.']);
            $this->markerArray['VIEWCOLLECTIONLINK'] = ($collectionCount >= $this->conf['minimumitems_toviewcollectionlink'])? $this->markerArray['VIEWCOLLECTIONLINK'] : '';
        } else {
            // clear template and marker stuff for 'VIEWCOLLECTIONTOOLBARLISTSECTION' we dont have
            if ($this->cObj->getSubpart($this->templateCode, '###VIEWCOLLECTIONTOOLBARLISTSECTION###')) {
                $this->templateCode = str_replace(($this->cObj->getSubpart($this->templateCode, '###VIEWCOLLECTIONTOOLBARLISTSECTION###')), '<!-- no viewcollectiontoolbarlist -->', $this->templateCode);
            }
                // clear template and marker stuff for 'VIEWCLEARALLLINKSECTION' we dont have
            if ($this->cObj->getSubpart($this->templateCode, '###VIEWCLEARALLLINKSECTION###')) {
                $this->templateCode = str_replace(($this->cObj->getSubpart($this->templateCode, '###VIEWCLEARALLLINKSECTION###')), '<!-- no viewclearalllink -->', $this->templateCode);
            }
                // clear template and marker stuff for 'VIEWCOLLECTIONLISTSECTION' we dont have
            if ($this->cObj->getSubpart($this->templateCode, '###VIEWCOLLECTIONLISTSECTION###')) {
                $this->templateCode = str_replace(($this->cObj->getSubpart($this->templateCode, '###VIEWCOLLECTIONLISTSECTION###')), '<!-- no viewcollectionlist -->', $this->templateCode);
            }
                // clear template and marker stuff for 'VIEWCOLLECTIONLINKSECTION' we dont use
            if ($this->cObj->getSubpart($this->templateCode, '###VIEWCOLLECTIONLINKSECTION###')) {
                $this->templateCode = str_replace(($this->cObj->getSubpart($this->templateCode, '###VIEWCOLLECTIONLINKSECTION###')), '<!-- no viewcollectionlink -->', $this->templateCode);
            }
                //  stuff for 'VIEWCOLLECTIONINFOSECTION' when empty collection
            $this->markerArray['COLLECTIONINFO'] = $this->pi_getLL('collectioninfo_empty');
        }
            // view link to clear/delete current collection
        $imageDelete = $this->cObj->cObjGetSingle('IMAGE', array('file' => $this->imagesConf['path'].$this->imagesConf['prozessdelete_img_small'], 'alttext' => $this->pi_getLL('prozess_delete')));
        $imageDelete = $this->local_cObj->stdWrap($imageDelete, $this->displayConf['clearallimage_stdWrap.']);
        $linkText_clearAll = $this->local_cObj->stdWrap($this->pi_getLL('clearall'), $this->displayConf['clearall_stdWrap.']);
        $this->markerArray['VIEWCLEARALLLINK'] = $this->pi_linkTP_keepPIvars($imageDelete.$linkText_clearAll, array('prozess' => 'clearall', 'ctrl' => $this->oldProzessControler, 'pid' => 'x'), $this->keepPIvarsCache);
        $this->markerArray['VIEWCLEARALLLINK'] = ($collectionCount >= $this->conf['minimumitems_toviewclearalllink'])? $this->markerArray['VIEWCLEARALLLINK'] : '';
            // view link to 'about this tool/what is page collect' #whatispagecollect
        $linkText_whatIsPageCollect = $this->local_cObj->stdWrap($this->pi_getLL('whatispagecollect'), $this->displayConf['whatispagecollect_stdWrap.']);
        $templateflex_pidOfwhatIsPageCollect = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'pidOfwhatIsPageCollect', 'sDEF');
        $pidOfwhatIsPageCollect = $templateflex_pidOfwhatIsPageCollect ? $templateflex_pidOfwhatIsPageCollect : $this->conf['pidOfwhatIsPageCollect'];
        $this->markerArray['WHATISPAGECOLLECT'] = $this->pi_linkToPage($linkText_whatIsPageCollect, $pidOfwhatIsPageCollect, '', array()); // pi_linkToPage($str,$id,$target='',$urlParameters=array())
            // view errors or not
        if ($this->cObj->getSubpart($this->templateCode, '###ERRORINFO###')) {
            if ($this->markerArray['ERROR']) {
                $this->markerArray['ERROR'] = $this->local_cObj->stdWrap($this->markerArray['ERROR'], $this->displayConf['error_stdWrap.']);
            } else {
                // clear template and marker stuff for error we dont have
                $this->templateCode = str_replace(($this->cObj->getSubpart($this->templateCode, '###ERRORINFO###')), '<!-- no errors -->', $this->templateCode);
            }
        }
            // view success or not
        if ($this->cObj->getSubpart($this->templateCode, '###SUCCESSINFO###')) {
            if ($this->markerArray['SUCCESS']) {
                $this->markerArray['SUCCESS'] = $this->local_cObj->stdWrap($this->markerArray['SUCCESS'], $this->displayConf['success_stdWrap.']);
            } else {
                // clear template and marker stuff for error we dont have
                $this->templateCode = str_replace(($this->cObj->getSubpart($this->templateCode, '###SUCCESSINFO###')), '<!-- no success -->', $this->templateCode);
            }
        }
            // if any page was not available (hidden, deleted OR access restricted)
        if ($this->pagesNotFoundCount) {
            $this->markerArray['COLLECTIONINFO'] .= sprintf($this->local_cObj->stdWrap($this->pi_getLL('collectioninfo_pagesnotfound'), $this->displayConf['collectioninfo_pagesnotfound_stdWrap.']), $this->pagesNotFoundCount);
        }
        return $this->cObj->substituteMarkerArray($this->templateCode, $this->markerArray, '###|###', 0);
    }


    /**
     * INITIALISATION
     *
     * @return void
     */

    public function init()
    {
        global $TCA;
            // clean incomming data
        $this->cleanThisPiVars();
            // ContentObjectRenderer
        $this->local_cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer'); // Local cObj.
            // init FlexForm Values from the Content Element
        $this->pi_initPIflexForm(); // Init FlexForm configuration for plugin
            // sys_language_mode defines what to do if the requested translation is not found
        $this->sys_language_mode = $this->conf['sys_language_mode']?$this->conf['sys_language_mode'] : $GLOBALS['TSFE']->sys_language_mode;
            // get id of the storage page
        #$pidList_flex = $this->cObj->data['pages']; // uses storage folder in CE plugin setting, not written in flexform
        $pidList_flex = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'page', 'sDEF');
        $this->pidList = ($pidList_flex)? $pidList_flex : (($this->conf['pid_list'])? $this->conf['pid_list'] : 0); // plugin.tx_eepcollect_pi1.pid_list
            // get User identify (v.1.0.6) .. should be a separate function
            // identify mode (by 1 = only cookie, 2 = only feuser, 3 = cookie OR feuser)
        $identify_mode_flex = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'identify_mode', 'sDEF');
        $this->identifyMode = ($identify_mode_flex)? $identify_mode_flex : $this->conf['default_identify_mode'];
        switch ($this->identifyMode) {
            default:
            case '1':    // only cookie (default)
                $this->feuserID = false;
                break;
            case '2':    // only feuser
            case '3':    // cookie OR feuser
                if ($GLOBALS['TSFE']->fe_user->user['uid']) {
                    $this->feuserID = $GLOBALS['TSFE']->fe_user->user['uid'];
                } else {
                    $this->feuserID = false;
                }
                break;
        }
            // Read the template from TS-configuration or the flexform
        $templateflex_file = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'template_file', 'sDEF');
        $this->template = $this->cObj->fileResource($templateflex_file?'uploads/tx_eepcollect/' . $templateflex_file:$this->conf['templateFile']);
            // set part of template file as templatecode
        if ($this->template) {
            $view_mode_flex = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'view_mode', 'sDEF');
            $view_mode = ($view_mode_flex)? $view_mode_flex : $this->conf['default_view_mode'];
            if ($view_mode == 'view_prozess_mode') {
                // templatesection for prozess-mode/toolbar
                $this->templateCode = $this->cObj->getSubpart($this->template, '###COLLECTDISPLAY_TOOLBAR###');
            } elseif ($view_mode == 'view_list_mode') {
                // templatesection for list-mode/resultlist
                $this->templateCode = $this->cObj->getSubpart($this->template, '###COLLECTDISPLAY_RESULTLIST###');
            } else {
                $this->templateCode = $this->pi_getLL('error_noviewmode');
            }
        } else {
            // Template was not found or defined... take help-template
            $this->template = $this->cObj->fileResource('EXT:eepcollect/template/no_template.tmpl');
            $this->templateCode = $this->cObj->getSubpart($this->template, '###COLLECTDISPLAY_ERROR###');
        }
            // get stdWraps for special values (time, degree, etc.)
        $this->displayConf = $this->conf['display.'];
            // get images (time, degree, etc.)
        $this->imagesConf = $this->conf['images.'];
            // get list/array of excluded page (which don't should be a part of collection/hide currentpageprozess)
            // get from flex
        $pidOfExcludedPages_flex = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'pidOfExcludedPages', 'sDEF');
        $pidOfExcludedPages_flexArray = ($pidOfExcludedPages_flex) ? explode(',', $pidOfExcludedPages_flex, 1000) : array();
            // get from TS
        $pidOfExcludedPages_conf = $this->conf['pidOfExcludedPages'];
        $pidOfExcludedPages_confArray = (trim($pidOfExcludedPages_conf)) ? explode(',', trim($pidOfExcludedPages_conf), 1000) : array();
            // merge flex and TS settings
        $this->pidOfExcludedPages = array_merge($pidOfExcludedPages_flexArray, $pidOfExcludedPages_confArray);
            // current page infos
        $this->currPageId = $GLOBALS['TSFE']->id;
        $this->currPageTitle = $GLOBALS['TSFE']->page['title'];
            // cookie expire
        $this->cookieStorageLifeExpires = ($this->conf['cookieStorageLifeExpires']) ? (time()+ ($this->conf['cookieStorageLifeExpires'])) : time()+60 * 60 * 24 * 30; // 30days
            // for relaod/back/forward browseraction we need to control the last setcookie-action
        $this->newProzessControler = $GLOBALS['EXEC_TIME'];
            // get cookie
        $this->get_cookie(); // sets the '$this->oldIdListArray' and '$this->oldProzessControler'
        $this->currentPageCollectorValueArray = ($this->oldIdListArray) ? $this->oldIdListArray : array();
            // if cookies are disabled, stop prozessing here and view alert
        if (!$this->cookieEnabled) {
            // cookies are disabled (alert to enable cookies)
            $this->markerArray['COOKIEINFO'] = $this->local_cObj->stdWrap($this->pi_getLL('enableyourcookie'), $this->displayConf['enableyourcookie_stdWrap.']);
                // stop any further prozessing of pagecollecting
            return;
        } else {
            $this->markerArray['COOKIEINFO'] = false;
        }
            // clear template and marker stuff for 'COOKIEINFOSECTION' if there is no reason to alert
        if (!$this->markerArray['COOKIEINFO'] && $this->cObj->getSubpart($this->templateCode, '###COOKIEINFOSECTION###')) {
            $this->templateCode = str_replace(($this->cObj->getSubpart($this->templateCode, '###COOKIEINFOSECTION###')), '<!-- no cookieinfosection -->', $this->templateCode);
        }
            // set prozess
            // we already has got GPvars: $this->piVars; $this->piVars['prozess']; $this->piVars['pid']; $this->piVars['ctrl'];
        $this->prozessPageCollector = $this->prozessPageCollectorActions(); // sets the '$this->oldIdListArray' and '$this->oldProzessControler'
    }


    /**
     * read from cookie
     *
     * @return void
     */

    public function get_cookie()
    {
        /*
         * any action/prozess for collection can only execute after cookie was set
         * this is the only way, to check out, if cookies are enabled/disabled
         */
        $this->cookieEnabled = true;
            /*
             * no cookie-infos, if a known session id is given (feks. by GET- or POST-parameter) &tx_eepcollect_pi1[code]=123456
             * this feature is not ready yet. it just will display any given/predefined id lists from DBase,
             * all actions will destroy these predefined collections
             */
        if ($this->piVars['code']) {
            $id = $this->piVars['code'];
        } else {
            $id = isset($_COOKIE[$this->prefixId]) ? strip_tags($_COOKIE[$this->prefixId]) : '';
            $id = preg_replace('/[^a-zA-Z0-9]+/', '', $id);
        }
            // if id by cookie or any given 'code' exists
        if ($id) {
            $this->cookieEnabled = true;
                // transform idList from cookie to DBase since changes from version 0.0.2 and restore this cookie
            $sessionIdFromTransformCookie = $this->transformIdListFromCookie($id);
            $this->sessionID = ($sessionIdFromTransformCookie) ? $sessionIdFromTransformCookie : $id;
                // read available session-data
            $userSession = $this->readUserSession();
                // get collected id's
            if ($userSession) {
                $this->get_idList($userSession['ses_data']);
                $this->oldProzessControler = $userSession['ses_tstamp'];
            } else {
                if ($this->piVars['prozess']) {
                    // when no userSession in table create a new one (feks. if the table would have been cleared)
                    $this->createUserSession($this->sessionID);
                }
                    // update cookie expired date
                SetCookie($this->prefixId, $this->sessionID, $this->cookieStorageLifeExpires, '/');
                    // clear prozess control
                $this->oldProzessControler = false;
            }
            // if no cookie
        } else {
            $this->oldIdListArray = false;
            $this->oldProzessControler = false;
                // set totaly new session
            $this->hash_length = \TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($this->hash_length, 6, 32);
            $this->sessionID = substr(md5(uniqid('').getmypid()), 0, $this->hash_length);
                // if cookies are not disabled
            if (!$this->piVars['prozess']) {
                $this->cookieEnabled = true;
                // set cookie
                SetCookie($this->prefixId, $this->sessionID, $this->cookieStorageLifeExpires, '/');
            } else {
                // cookies are disabled !!!
                $this->cookieEnabled = false;
                    // when cookies just has been aktivated
                SetCookie($this->prefixId, $this->sessionID, $this->cookieStorageLifeExpires, '/');
            }
        }
    }


    /**
     * read stored ID's from given session-data
     *
     * @param String  $sessionData: commaseparated list of id's
     * @return void
     */

    public function get_idList($sessionData)
    {
        if ($sessionData) {
            // get values from session data
            $this->oldIdListString = $sessionData;
            $this->oldIdListString = str_replace(',,', ',', trim($this->oldIdListString));
            $this->oldIdListArray = explode(',', trim($this->oldIdListString), 1000);
        } else {
            $this->oldIdListArray = false;
            $this->oldProzessControler = false;
        }
    }


    /**
     * check prozess of page-collection actions comming during GPvars: $this->piVars
     *
     * @return Array	containing session and prozess for further needs
     */

    public function prozessPageCollectorActions()
    {
        // do clear all
        /*
        if ($this->piVars['prozess'] == 'clearall') {
        $this->doPageCollectorActions();
        return array('session' => 1,'prozess' => $this->piVars['prozess']);
        }
         */
            // check pid and other important things befor start prozessing
        if (!$this->piVars['prozess'] || !$this->piVars['pid'] || !$this->piVars['ctrl']) {
            $this->markerArray['ERROR'] = ($this->piVars['prozess']) ? $this->pi_getLL('error_nochanges') : false;
            return 'GPvars not correct';
        }
            // depend on session is given or not
        if ($this->oldIdListArray) {
            if ($this->piVars['prozess'] && ($this->piVars['ctrl'] == $this->oldProzessControler || $this->piVars['ctrl'] == 'addList')) {
                $this->doPageCollectorActions();
                return array('session' => 1, 'prozess' => $this->piVars['prozess']);
            } else {
                $this->markerArray['ERROR'] = $this->pi_getLL('error_oldsession');
                return array('session' => 1, 'prozess' => 0);
            }
        } else {
            // no session or session is empty of any pid values
            if ($this->piVars['prozess']) {
                // set new currentPageCollectorValueArray
                $this->doPageCollectorActions();
                return array('session' => 0, 'prozess' => $this->piVars['prozess']);
            } else {
                return array('session' => 0, 'prozess' => 0);
            }
        }
        return;
    }


    /**
     * do prozess of page-collection actions comming during GPvars: $this->piVars
     *
     * @return void
     */

    public function doPageCollectorActions()
    {
        // add
        if ($this->piVars['prozess'] == 'add') {
            $this->currentPageCollectorValueArray[] = $this->piVars['pid'];
                // delete
        } elseif ($this->piVars['prozess'] == 'del') {
            $changedPageCollectorValueArray = array();
            while (list($k, $v) = each($this->currentPageCollectorValueArray)) {
                if ($v != $this->piVars['pid']) {
                    $changedPageCollectorValueArray[] = $v;
                } else {
                    // no new value
                }
            }
                // rechange
            $this->currentPageCollectorValueArray = $changedPageCollectorValueArray;
            // move up
        } elseif ($this->piVars['prozess'] == 'up') {
            // get changings
            $keyCurrentMove = array_search($this->piVars['pid'], $this->currentPageCollectorValueArray);
            $valCurrentMove = $this->piVars['pid'];
            $keyContiguousMove = $keyCurrentMove -1;
            $valContiguousMove = $this->currentPageCollectorValueArray[$keyContiguousMove];
                // make changings now
            $this->currentPageCollectorValueArray[$keyContiguousMove] = $valCurrentMove;
            $this->currentPageCollectorValueArray[$keyCurrentMove] = $valContiguousMove;
                // move down
        } elseif ($this->piVars['prozess'] == 'down') {
            // get changings
            $keyCurrentMove = array_search($this->piVars['pid'], $this->currentPageCollectorValueArray);
            $valCurrentMove = $this->piVars['pid'];
            $keyContiguousMove = $keyCurrentMove +1;
            $valContiguousMove = $this->currentPageCollectorValueArray[$keyContiguousMove];
                // make changings now
            $this->currentPageCollectorValueArray[$keyContiguousMove] = $valCurrentMove;
            $this->currentPageCollectorValueArray[$keyCurrentMove] = $valContiguousMove;
                // add a holy list of pids (used via hmenu & TSscript by vikingeskibsmussets 'spor')
        } elseif ($this->piVars['prozess'] == 'addList') {
            $newPageCollectorValueArray = explode(',', $this->piVars['pid'], 1000);
            while (list($k, $v) = each($newPageCollectorValueArray)) {
                if (!in_array($v, $this->currentPageCollectorValueArray)) {
                    array_push($this->currentPageCollectorValueArray, $v);
                }
            }
            // clearall action
        } elseif ($this->piVars['prozess'] == 'clearall') {
            $this->currentPageCollectorValueArray = array();
            // any other action
        } else {
            // any other action can be placed here
        }
            // any changings will result in dbUpdate for this session
        $this->updateUserSession();
        return;
    }


    /**
     * COLLECTION INFOS AND LINKED STUFF
     *
     * @param String  containing template
     * @return void
     */

    public function view_pageCollector($templateSection)
    {
        // template and marker stuff
        $templateCodeSubpartItem = $this->cObj->getSubpart($this->templateCode, '###'.$templateSection.'###');
        $currentPageCollectorTitleArray = $this->get_currentPageCollectorTitleArray($this->currentPageCollectorValueArray);
        if (!$currentPageCollectorTitleArray) {
            return;
        }
        $count_currentPageCollectorTitleArray = count($currentPageCollectorTitleArray);
        $i = 0;
            // arrange delet/move items for each current page Collections
        while (list($k, $v) = each($currentPageCollectorTitleArray)) {
            $pid = $v[0];
            $pageTitle = $v[1];
            $pageRootline = $v[2];
                // delete item
            $imageDelete = $this->cObj->cObjGetSingle('IMAGE', array('file' => $this->imagesConf['path'].$this->imagesConf['prozessdelete_img_small'], 'alttext' => $this->pi_getLL('prozess_delete')));
            $prozessDeleteLink = $this->pi_linkTP_keepPIvars($imageDelete, array('prozess' => 'del', 'pid' => $pid, 'ctrl' => $this->oldProzessControler), $this->keepPIvarsCache);
            //$imageAdd = $this->cObj->cObjGetSingle('IMAGE', array('file'=>$this->imagesConf['path'].$this->imagesConf['prozessadd_img_small'],'alttext'=>$this->pi_getLL('prozess_add')));
            //$prozessAddLink = $this->pi_linkTP_keepPIvars($imageAdd,array('prozess'=>'add','pid'=>$pid,'ctrl'=>$this->oldProzessControler), $this->keepPIvarsCache);
                // move (up and down) items, make a differnce in links for first an last item (first item cant move higher up and so on...)
            if ($i == 0 && $count_currentPageCollectorTitleArray > 1) {
                // first elemnet
                $imageMoveUpDisabled = $this->cObj->cObjGetSingle('IMAGE', array('file' => $this->imagesConf['path'].$this->imagesConf['prozessmoveupdisabled_img_small'], 'alttext' => $this->pi_getLL('')));
                $prozessMoveUpLink = $imageMoveUpDisabled;
                $imageMoveDown = $this->cObj->cObjGetSingle('IMAGE', array('file' => $this->imagesConf['path'].$this->imagesConf['prozessmovedown_img_small'], 'alttext' => $this->pi_getLL('prozess_movedown')));
                $prozessMoveDownLink = $this->pi_linkTP_keepPIvars($imageMoveDown, array('prozess' => 'down', 'pid' => $pid, 'ctrl' => $this->oldProzessControler), $this->keepPIvarsCache);
            } elseif ($i == ($count_currentPageCollectorTitleArray - 1) && $count_currentPageCollectorTitleArray > 1) {
                // last elemnet
                $imageMoveUp = $this->cObj->cObjGetSingle('IMAGE', array('file' => $this->imagesConf['path'].$this->imagesConf['prozessmoveup_img_small'], 'alttext' => $this->pi_getLL('prozess_moveup')));
                $prozessMoveUpLink = $this->pi_linkTP_keepPIvars($imageMoveUp, array('prozess' => 'up', 'pid' => $pid, 'ctrl' => $this->oldProzessControler), $this->keepPIvarsCache);
                $imageMoveDownDisabled = $this->cObj->cObjGetSingle('IMAGE', array('file' => $this->imagesConf['path'].$this->imagesConf['prozessmovedowndisabled_img_small'], 'alttext' => $this->pi_getLL('')));
                $prozessMoveDownLink = $imageMoveDownDisabled;
            } elseif ($count_currentPageCollectorTitleArray > 1) {
                // all other elements between first and last
                $imageMoveUp = $this->cObj->cObjGetSingle('IMAGE', array('file' => $this->imagesConf['path'].$this->imagesConf['prozessmoveup_img_small'], 'alttext' => $this->pi_getLL('prozess_moveup')));
                $prozessMoveUpLink = $this->pi_linkTP_keepPIvars($imageMoveUp, array('prozess' => 'up', 'pid' => $pid, 'ctrl' => $this->oldProzessControler), $this->keepPIvarsCache);
                $imageMoveDown = $this->cObj->cObjGetSingle('IMAGE', array('file' => $this->imagesConf['path'].$this->imagesConf['prozessmovedown_img_small'], 'alttext' => $this->pi_getLL('prozess_movedown')));
                $prozessMoveDownLink = $this->pi_linkTP_keepPIvars($imageMoveDown, array('prozess' => 'down', 'pid' => $pid, 'ctrl' => $this->oldProzessControler), $this->keepPIvarsCache);
            } // else do not show any moving buttons
                //$this->markerArraySub['PROZESSADD'] = $this->local_cObj->stdWrap($prozessAddLink, $this->displayConf['prozessadd_stdWrap.']);
            $this->markerArraySub['PROZESSDELETE'] = $this->local_cObj->stdWrap($prozessDeleteLink, $this->displayConf['prozessdelete_stdWrap.']);
            $this->markerArraySub['PROZESSMOVEUP'] = $this->local_cObj->stdWrap($prozessMoveUpLink, $this->displayConf['prozessmoveup_stdWrap.']);
            $this->markerArraySub['PROZESSMOVEDOWN'] = $this->local_cObj->stdWrap($prozessMoveDownLink, $this->displayConf['prozessmovedown_stdWrap.']);
                // page id,title,rootline
            $this->markerArraySub['PAGEID'] = $pid;
            $this->markerArraySub['PAGETITLE'] = $this->local_cObj->stdWrap($pageTitle, $this->displayConf['collectionlist_pagetitle_stdWrap.']);
            $this->markerArraySub['PAGEROOTLINE'] = $this->local_cObj->stdWrap($pageRootline, $this->displayConf['collectionlist_pagerootline_stdWrap.']);
                // view title/rootline with pagelink
            $pagelinkType_flex = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'pagelinkType', 'sDEF');
            $pagelinkType = ($pagelinkType_flex)? $pagelinkType_flex : (($this->conf['pagelinkType'])? $this->conf['pagelinkType'] : '1');
            if ($pagelinkType == '1') {
                $pageLinkStr = $pageTitle;
            } elseif ($pagelinkType == '2') {
                $pageLinkStr = $pageRootline;
            }
            $pageLink = $this->pi_linkToPage($pageLinkStr, $pid, $target, $urlParameters);

            if ($pid == $GLOBALS['TSFE']->id) {
                $this->markerArraySub['PAGELINK'] = $this->local_cObj->stdWrap($pageLink, $this->displayConf['collectionlist_pagelinkcurrent_stdWrap.']);
            } else {
                $this->markerArraySub['PAGELINK'] = $this->local_cObj->stdWrap($pageLink, $this->displayConf['collectionlist_pagelink_stdWrap.']);
            }
                // URL of the marked pages (fx: to send it using powermail). Thanks to Falko Trojahn #9893
            $this->markerArraySub['PAGEURL'] = $this->local_cObj->stdWrap($this->pi_getPageLink($pid), $this->displayConf['collectionlist_pageurl_stdWrap.']);
                // view/append pagecontent
            /* Problem
             * here we found a bug, when using rgtabs on the same site: each PAGECONTENT does render included JS multiple during use of tslib_fe->INTincScript()
             * by the way: there is no reason to get all pagecontent, if no pagencontent should be rendered, defined by template
             */
                // check if PAGECONTENT should be rendered, and add to markerArray
            if (strpos($templateCodeSubpartItem, '###PAGECONTENT###')) {
                $this->markerArraySub['PAGECONTENT'] = $this->local_cObj->stdWrap($pid, $this->displayConf['pagecontent_stdWrap.']);
            }
            $i++;
            $listItem = $this->cObj->substituteMarkerArray($templateCodeSubpartItem, $this->markerArraySub, '###|###', 0);
                // Implementation of the "optionSplit" feature (like eg. for MENU objects)
            $displayConfListitem = $GLOBALS['TSFE']->tmpl->splitConfArray($this->displayConf['listitem.'], $count_currentPageCollectorTitleArray);
                // collect all items wrapped in one string
            $listItems .= $this->local_cObj->stdWrap($listItem, $displayConfListitem[$i-1]);
        }

        $this->templateCode = $this->cObj->substituteSubpart($this->templateCode, '###'.$templateSection.'###', $listItems);
    }


    /**
     * view current PageProzess ('add' or 'exists')
     *
     * @return Array	containing HTML snippets
     */

    public function view_currentPageProzess()
    {

            // set title
        $currentPageProzess['title'] = $this->currPageTitle;

            // arrange image (add/delete/move buttons)
            // set prozess info ('do add' or 'already added' or 'delete current')

            // when adding to any existing collection
        if ($this->currentPageCollectorValueArray && !in_array($this->currPageId, $this->currentPageCollectorValueArray)) {
            $image = $this->cObj->cObjGetSingle('IMAGE', array('file' => $this->imagesConf['path'].$this->imagesConf['prozessadd_img_big'], 'alttext' => $this->pi_getLL('prozess_add')));
            $currentPageProzess['image'] = $this->pi_linkTP_keepPIvars($image, array('prozess' => 'add', 'pid' => $GLOBALS['TSFE']->id, 'ctrl' => $this->oldProzessControler), $this->keepPIvarsCache);
            $currentPageProzess['text'] = $this->pi_linkTP_keepPIvars($this->pi_getLL('addCurrentPageToCollection'), array('prozess'=>'add','pid'=>$GLOBALS['TSFE']->id,'ctrl'=>$this->oldProzessControler), $this->keepPIvarsCache);

            // or when adding totaly new (collection/cookie is empty); change ProzessControler
        } elseif (!$this->currentPageCollectorValueArray) {
            $image = $this->cObj->cObjGetSingle('IMAGE', array('file' => $this->imagesConf['path'].$this->imagesConf['prozessadd_img_big'], 'alttext' => $this->pi_getLL('prozess_add')));
            $currentPageProzess['image'] = $this->pi_linkTP_keepPIvars($image, array('prozess' => 'add', 'pid' => $GLOBALS['TSFE']->id, 'ctrl' => $this->newProzessControler), $this->keepPIvarsCache);
            $currentPageProzess['text'] = $this->pi_linkTP_keepPIvars($this->pi_getLL('addCurrentPageToCollection'), array('prozess'=>'add','pid'=>$GLOBALS['TSFE']->id,'ctrl'=>$this->newProzessControler), $this->keepPIvarsCache);

            // if already exists in collection
            // and if it was current proceeded
        } elseif ($this->piVars['pid'] == $this->currPageId && $this->piVars['prozess'] == 'add') {
            $image = $this->cObj->cObjGetSingle('IMAGE', array('file' => $this->imagesConf['path'].$this->imagesConf['prozessokay_img_big'], 'alttext' => $this->pi_getLL('')));
            $currentPageProzess['image'] = $image;
            $currentPageProzess['text'] = $this->pi_getLL('currentPageInCollection');
            // if it wasnt current proceeded (delete is possible)
        } else {
            $image = $this->cObj->cObjGetSingle('IMAGE', array('file' => $this->imagesConf['path'].$this->imagesConf['prozessdelete_img_big'], 'alttext' => $this->pi_getLL('prozess_delete')));
            $currentPageProzess['image'] = $this->pi_linkTP_keepPIvars($image, array('prozess' => 'del', 'pid' => $GLOBALS['TSFE']->id, 'ctrl' => $this->oldProzessControler), $this->keepPIvarsCache);
            $currentPageProzess['text'] = $this->pi_linkTP_keepPIvars($this->pi_getLL('delCurrentPageToCollection'), array('prozess'=>'del','pid'=>$GLOBALS['TSFE']->id,'ctrl'=>$this->oldProzessControler), $this->keepPIvarsCache);
        }

        return $currentPageProzess;
    }


    /**
     * get page titles as array
     *
     * @param	Array	containing page id's
     * @return	Array containing page titles
     */
    public function get_currentPageCollectorTitleArray($currentPageCollectorValueArray)
    {
        if (is_array($currentPageCollectorValueArray)) {
            while (list($key, $uid) = each($currentPageCollectorValueArray)) {
                $uid = intval($uid);
                if ($uid) {
                    $page = $GLOBALS['TSFE']->sys_page->getPage($uid);
                    // check, if page is readable (hidden, delted OR access restricted)
                    if ($page) {
                        $rootlineArray = $GLOBALS['TSFE']->sys_page->getRootLine($uid);
                        // slice NUM levels from root
                        ksort($rootlineArray);
                        $slicedArray = array_slice($rootlineArray, $this->conf['pagerootline_startatlevel']);
                        krsort($slicedArray);
                        $rootlinePath = $GLOBALS['TSFE']->sys_page->getPathFromRootline($slicedArray, $this->conf['pagerootline_titlelength']);
                        $currentPageCollectorTitleArray[$key] = array($page['uid'], $page['title'], $rootlinePath);
                    } else {
                        $pagesNotFoundCount ++;
                    }
                }
            }
            $this->pagesNotFoundCount = $pagesNotFoundCount;
            // sort and return
            if (is_array($currentPageCollectorTitleArray)) {
                ksort($currentPageCollectorTitleArray);
            }
        }
        return $currentPageCollectorTitleArray;
    }


    /*************************
     *
     * Database User Sessions
     * read and update or save
     * sessions & collection
     * in db (tx_eepcollect_sessions)
     *
     *************************/


    /**
     * Creates a user session record in table tx_eepcollect_session.
     *
     * @param string  $sessionID: md5 string
     * @param string  $idListString: commaseparated list of ID's
     * @return void
     */

    public function createUserSession($sessionID, $idListString='')
    {
        if ($sessionID or $this->feuserID) {
            // inserts
            $insertFields = array(
                'pid' => $this->pidList,
                'ses_tstamp' => $this->newProzessControler,
                'ses_data' => $idListString,
            );
                // inserts for identify mode (by 1 = only cookie, 2 = only feuser, 3 = cookie OR feuser)
            switch ($this->identifyMode) {
                default:
                case '1':    // only cookie (default)
                    $insertFields['ses_id'] = $sessionID;
                    break;
                case '2':    // only feuser
                    $insertFields['feuser_id'] = $this->feuserID;
                    break;
                case '3':    // cookie OR feuser
                    $insertFields['ses_id'] = $sessionID;
                    $insertFields['feuser_id'] = $this->feuserID;
                    break;
            }
                // create session entry
            $GLOBALS['TYPO3_DB']->exec_INSERTquery($this->sessionTable, $insertFields);
                // insert execution should be checked
            #$sql_insert_id = $GLOBALS['TYPO3_DB']->sql_insert_id();
        } else {
        }
    }


    /**
     * Update a user session record.
     *
     * @return void
     */

    public function updateUserSession()
    {
        //  get id list as string
        if ($this->currentPageCollectorValueArray) {
            $this->currentPageCollectorValueString = implode(',', $this->currentPageCollectorValueArray);
        } else {
            $this->currentPageCollectorValueString = false;
        }
            // update cookie (expire date)
        SetCookie($this->prefixId, $this->sessionID, $this->cookieStorageLifeExpires, '/');
            // write changes to DBase
            // updatefields
        $updateFields = array(
            'ses_tstamp' => $GLOBALS['EXEC_TIME'],
            'ses_data' => $this->currentPageCollectorValueString,
        );
            // where
        $where = '1=1';
            // where identify mode (by 1 = only cookie, 2 = only feuser, 3 = cookie OR feuser)
        $where_sessionID = $this->sessionID ? ' ses_id = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($this->sessionID, $this->sessionTable) : '';
        $where_feuserID = $this->feuserID ? ' feuser_id = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($this->feuserID, $this->sessionTable) : '';
        switch ($this->identifyMode) {
            default:
            case '1':    // only cookie (default)
                $where .= $where_sessionID ? ' AND' . $where_sessionID : '';
                break;
            case '2':    // only feuser
                $where .= $where_feuserID ? ' AND' . $where_feuserID : '';
                break;
            case '3':    // cookie OR feuser
                if ($where_sessionID || $where_feuserID) {
                    if ($where_sessionID && $where_feuserID) {
                        $where .= ' AND (' . $where_sessionID . ' OR ' . $where_feuserID . ')';
                    } else {
                        $where .= $where_sessionID ? ' AND' . $where_sessionID : '';
                        $where .= $where_feuserID ? ' AND' . $where_feuserID : '';
                    }
                }
                    // insert feuserID, if not exist
                $check_feuserID = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid,feuser_id', $this->sessionTable, 'ses_id ='.$GLOBALS['TYPO3_DB']->fullQuoteStr($this->sessionID, $this->sessionTable), $groupBy, $orderBy, 1);
                if ($check_feuserID[0]['uid'] && !$check_feuserID[0]['feuser_id']) {
                    $updateFields['feuser_id'] = $this->feuserID;
                }
                break;
        }
            // pid
        $where .= ' AND pid = ' . $this->pidList;
            // update session entry
        $GLOBALS['TYPO3_DB']->exec_UPDATEquery($this->sessionTable, $where, $updateFields);
            // the update execution should be checked
        #$sql_update_rows = $GLOBALS['TYPO3_DB']->sql_affected_rows();
            // reset ProzessControler
        $this->oldProzessControler = $this->newProzessControler;
        $this->markerArray['SUCCESS'] = $this->pi_getLL('success_changes');
    }


    /**
     * Read from a user session record.
     *
     * @return Array	containing table row
     */

    public function readUserSession()
    {
        // check DB-table and read session from db
            // where
        $where = '1=1';
            // where identify mode (by 1 = only cookie, 2 = only feuser, 3 = cookie OR feuser)
        $where_sessionID = $this->sessionID ? ' ses_id = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($this->sessionID, $this->sessionTable) : '';
        $where_feuserID = $this->feuserID ? ' feuser_id = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($this->feuserID, $this->sessionTable) : '';
        switch ($this->identifyMode) {
            default:
            case '1':    // only cookie (default)
                $where .= $where_sessionID ? ' AND' . $where_sessionID : '';
                break;
            case '2':    // only feuser
                $where .= $where_feuserID ? ' AND' . $where_feuserID : '';
                break;
            case '3':    // cookie OR feuser
                if ($where_sessionID || $where_feuserID) {
                    if ($where_sessionID && $where_feuserID) {
                        $where .= ' AND (' . $where_sessionID . ' OR ' . $where_feuserID . ')';
                    } else {
                        $where .= $where_sessionID ? ' AND' . $where_sessionID : '';
                        $where .= $where_feuserID ? ' AND' . $where_feuserID : '';
                    }
                }
                break;
        }
            // pid
        $where .= ' AND pid = ' . $this->pidList;
            // exec
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', $this->sessionTable, $where);
        $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
        return $row;
    }


    /**
     * transform a given idList stored directly in cookie to store it in DBase since changes from version 0.0.2
     *
     * the old way in version 0.0.2 was to store all ID's commaseparated directly into the cookie
     * the new way since version 0.1.0 was to store all ID's into DBase table 'tx_eepcollect_sessions'
     * in this case, any update from version 0.0.2 should be done, here the stored ID's will be transmitted to DBase
     * the only way to check out of it, is to check commaseparated listing by any existing delimiter of ','
     *
     * @return Int	session id
     */

    public function transformIdListFromCookie($IdList)
    {
        $this->hash_length = \TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($this->hash_length, 6, 32);
        $sessionID = substr(md5(uniqid('').getmypid()), 0, $this->hash_length);
        if (strstr($IdList, ',')) {
            // get ID's from cookie
            $cookieValueString = str_replace(',,', ',', $IdList);
            $cookieValueArray = explode(',', $cookieValueString, 1000);
            $cookieProzessControler = array_shift($cookieValueArray);
            $cookieIdListString = implode(',', $cookieValueArray);
                // create userSession
            $this->createUserSession($sessionID, $cookieIdListString);
                // update cookie
            SetCookie($this->prefixId, $sessionID, $this->cookieStorageLifeExpires, '/');
            return $sessionID;
        } else {
            // update cookie if no list but old prozesscontroler (string longer than 6 chars)
            if (strlen($IdList) != $this->hash_length) {
                SetCookie($this->prefixId, $sessionID, $this->cookieStorageLifeExpires, '/');
                return $sessionID;
            } else {
                return false;
            }
        }
    }

    /**
     * Clean this pi Vars
     * Unset all piVars, if no match
     *
     * @return void
     */
    protected function cleanThisPiVars()
    {
        if (!empty($this->piVars)) {
            $piVarsBefore = hash('md5', serialize($this->piVars));
            foreach ($this->piVars as $key => $val) {
                switch ($key) {
                    case 'code':
                        $this->piVars['code'] = preg_replace('/[^a-zA-Z0-9]+/', '', $val);
                        break;
                    case 'ctrl':
                        $this->piVars['ctrl'] = preg_replace('/[^0-9]+/', '', $val);
                        break;
                    case 'pid':
                        $this->piVars['pid'] = preg_replace('/[^0-9]+/', '', $val);
                        break;
                    case 'prozess':
                        $this->piVars['prozess'] = preg_replace('/[^a-zA-Z]+/', '', $val);
                        break;
                    default:
                        unset($this->piVars[$key]);
                        break;
                }
            }
            $piVarsAfter = hash('md5', serialize($this->piVars));
            if ($piVarsBefore !== $piVarsAfter) {
                $this->piVars = array();
            }
        }
    }
}
