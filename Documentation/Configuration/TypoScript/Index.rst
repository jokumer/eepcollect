

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


TypoScript reference
^^^^^^^^^^^^^^^^^^^^


General settings
""""""""""""""""

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         templateFile

   Data type
         File

   Description
         File resource to the HTML-Template. You can also define a template file with higher priority inside the flexform of the contentelement for this plugin.

   Default
         EXT:eepcollect/Resources/Private/Templates/eepcollect_pi1.tmpl


.. container:: table-row

   Property
         pid_list

   Data type
         Int

   Description
         StoragePage where collections are saved

   Default
         0


.. container:: table-row

   Property
         cookieStorageLifeExpires

   Data type
         Int

   Description
         Time in seconds how long the cookie with collection of pages should be alive for the client, after creating any collection

   Default
         60*60*24*30 = 2592000


.. container:: table-row

   Property
         pidOfListPageCollect

   Data type
         Int

   Description
         Page where you can view a list of all collected pages. Uses template marker ###VIEWCOLLECTIONLINK### and builds a link to it

   Default
         empty


.. container:: table-row

   Property
         pidOfwhatIsPageCollect

   Data type
         Page uid

   Description
         Page where you can view more information about how to use and so on. Creates a titled link (_LOCAL_LANG.default.whatispagecollect) in the template by ###WHATISPAGECOLLECT###

   Default
         empty


.. container:: table-row

   Property
         pidOfExcludedPages

   Data type
         List of page uid's

   Description
         Comma separated list of pages, where the selecttoolbarbuttons should not be available. Pages, which shouldn't be a part of pagecollection, but the collectionoverview can be viewed. Will be merged with Flexform settings.

   Default
         empty


.. container:: table-row

   Property
         default_view_mode

   Data type
         String

   Description
         Sets the view for plugin. Use:

         'view_list_mode' … show list of collected pages

         'view_prozess_mode' … show toolbar

   Default
         view_list_mode


.. container:: table-row

   Property
         default_identify_mode

   Data type
         Int

   Description
         Sets how to identify the user, using cookies or feuser login. Use:

         '1' … identify by cookie only

         '2' … identify by feuser only

         '3' … identify by both cookie and feuser

         (3 … in a special situation it builds two collections, which can't be
         merged automaticly)

   Default
         1


.. container:: table-row

   Property
         minimumitems_toviewcollectionlink

   Data type
         Int

   Description
         Minimum items in collection, to view link to the whole collection

   Default
         1


.. container:: table-row

   Property
         minimumitems_toviewclearalllink

   Data type
         Int

   Description
         Minimum items in collection, to view a 'clearAll' link in list.

   Default
         2


.. container:: table-row

   Property
         pagelinkType

   Data type
         Int

   Description
         Shows pagelink as title only or as full rootline. Use:

         '0' … Pagetitle

         '1' … Rootline

   Default
         0


.. container:: table-row

   Property
         pagerootline_startatlevel

   Data type
         Int

   Description
         If you view rootline for each collected page, you can change the startlevel

   Default
         0


.. container:: table-row

   Property
         pagerootline_titlelength

   Data type
         Int

   Description
         If you view rootline for each collected page, you can change the string-length for the whole rootline

   Default
         20


Settings for display
""""""""""""""""""""

It's possible to manipulate a range of template items by the following stdWraps)


.. container:: table-row

   Property
         listitem.wrap

   Data type
         stdWrap

   Description
         Possibility for optionSplit wrap-functions

   Default
         wrap = ||*<hr />||*|<hr />||*||


.. container:: table-row

   Property
         currentpageprozessimage_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         currentpageprozesstext_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         currentpageprozesstitle_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         collectioninfo_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         collectioninfo_pagesnotfound_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         viewcollectionlink_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         whatispagecollect_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         debuginfo_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         error_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         success_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         prozessadd_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         prozessdelete_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         prozessmoveup_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         prozessmovedown_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         collectionlist_pagelinkcurrent_stdWrap

   Data type
         stdWrap

   Description
         The link in the list, which is equal to the current viewed page

   Default
         wrap = <strong>|</strong>


.. container:: table-row

   Property
         collectionlist_pagelink_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         collectionlist_pageurl_stdWrap

   Data type
         stdWrap

   Default
         empty


.. container:: table-row

   Property
         collectionlist_pagetitle_stdWrap

   Data type
         stdWrap

   Default
         empty


Settings for images
"""""""""""""""""""


.. container:: table-row

   Property
         path

   Data type
         string/path

   Description
         Path to your image folder

   Default
         typo3conf/ext/eepcollect/res/


.. container:: table-row

   Property
         prozessadd_img_small

   Data type
         imgfile

   Description
         Small button for 'add'

   Default
         button_plus.gif


.. container:: table-row

   Property
         prozessdelete_img_small

   Data type
         imgfile

   Description
         Small button for 'delete'

   Default
         button_minus.gif


.. container:: table-row

   Property
         prozessmoveup_img_small

   Data type
         imgfile

   Description
         Small button for 'move up' sorting

   Default
         button_up.gif


.. container:: table-row

   Property
         prozessmoveupdisabled_img_small

   Data type
         imgfile

   Description
         Small disabled button, can't move up, first item

   Default
         button_up_disabled.gif


.. container:: table-row

   Property
         prozessmovedown_img_small

   Data type
         imgfile

   Description
         Small button for 'move down' sorting

   Default
         button_down.gif


.. container:: table-row

   Property
         prozessmovedowndisabled_img_small

   Data type
         imgfile

   Description
         Small disabled button, can't move down, last item

   Default
         button_down_disabled.gif


.. container:: table-row

   Property
         prozessadd_img_big

   Data type
         imgfile

   Description
         Big button for 'add'

   Default
         bigbutton_plus.gif


.. container:: table-row

   Property
         prozessdelete_img_big

   Data type
         imgfile

   Description
         Big button for 'delete'

   Default
         bigbutton_minus.gif


.. container:: table-row

   Property
         prozessokay_img_big

   Data type
         imgfile

   Description
         Big button if pages were successfully included

   Default
         bigbutton_okay.gif


Settings for _LOCAL_LANG
""""""""""""""""""""""""


.. container:: table-row

   Property
         enableyourcookie

   Data type
         string

   Description
         textinfo, that cookie couldn't be set/read ###COOKIEINFO###

   Default
         Activate your cookies!


.. container:: table-row

   Property
         whatispagecollect

   Data type
         string

   Description
         Link text to any page which contains information about this tool
         ###WHATISPAGECOLLECT###

   Default
         What is 'Pagecollect'?


.. container:: table-row

   Property
         error_unknown

   Data type
         string

   Default
         Any unknown Error occured.


.. container:: table-row

   Property
         error_nochanges

   Data type
         string

   Description
         Text info that no change appears in the collection.

   Default
         Pagecollection wasn't updated!


.. container:: table-row

   Property
         error_oldsession

   Data type
         string

   Description
         Text info that no change appears in the collection. This will happen if the visitor browses back/forward and refreshes the page, and any collectionoption was choosen.

   Default
         Pagecollection wasn't updated!


.. container:: table-row

   Property
         error_noviewmode

   Data type
         string

   Description
         If the admin didn’t choose any viewmode for the plugin, this message appears.

   Default
         No view-mode defined for this plugin!


.. container:: table-row

   Property
         success_changes

   Data type
         string

   Description
         Text info, that collection was successfully updated.

   Default
         Pagecollection updated!


.. container:: table-row

   Property
         collectioninfo

   Data type
         string

   Description
         Info about the summary of the collected pages.

   Default
         %s page(s) collected


.. container:: table-row

   Property
         collectioninfo_empty

   Data type
         string

   Description
         Info about the empty collection.

   Default
         No pages in collection.


.. container:: table-row

   Property
         addCurrentPageToCollection

   Data type
         string

   Description
         Link text to add current viewed page to the collection.

   Default
         Add this page:


.. container:: table-row

   Property
         delCurrentPageToCollection

   Data type
         string

   Description
         Link text to delete the page from collection.

   Default
         Delete this page:


.. container:: table-row

   Property
         currentPageAddToCollection

   Data type
         string

   Description
         Status to the added page.

   Default
         Added:


.. container:: table-row

   Property
         currentPageInCollection

   Data type
         string

   Description
         Status to the saved page.

   Default
         Page saved:


.. container:: table-row

   Property
         showFullPageCollection

   Data type
         string

   Description
         Link text for collectionresultlist ###VIEWCOLLECTIONLINK###

   Default
         Show pagecollection


.. container:: table-row

   Property
         prozess_add

   Data type
         string

   Description
         Alttext for toolbarbutton 'add'

   Default
         Add page


.. container:: table-row

   Property
         prozess_delete

   Data type
         string

   Description
         Alttext for toolbarbutton 'delete'

   Default
         Delete page


.. container:: table-row

   Property
         prozess_moveup

   Data type
         string

   Description
         Alttext for toolbarbutton 'moveup'

   Default
         Move page up


.. container:: table-row

   Property
         prozess_movedown

   Data type
         string

   Description
         Alttext for toolbarbutton 'movedown

   Default
         Move page down


.. ###### END~OF~TABLE ######

[tsref:plugin.tx_eepcollect_pi1]

