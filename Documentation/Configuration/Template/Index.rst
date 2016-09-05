

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


Markers for use in template
^^^^^^^^^^^^^^^^^^^^^^^^^^^

There are already defined styles inside the template file. It might be more useful to describe some classes for CSS and use them instead.


Mainsections for choosen view mode
""""""""""""""""""""""""""""""""""


.. container:: table-row

   Marker
         COLLECTDISPLAY_TOOLBAR

   .
         string

   Description
         Contain all markers to list and handle (toolbar features like 'add/delete/move') pages in collection


.. container:: table-row

   Marker
         COLLECTDISPLAY_RESULTLIST

   .
         string

   Description
         Contains all markers just to list the given collection without toolbar features


Subsections
"""""""""""

.. container:: table-row

   Marker
         CURRENTPAGEPROZESSSECTION

   .
         string

   Description
         Section for viewing current available option for current viewed paged


.. container:: table-row

   Marker
         CURRENTPAGEPROZESSIMAGE

   .
         string

   Description
         A button with the current available option for the current viewed page


.. container:: table-row

   Marker
         CURRENTPAGEPROZESSTEXT

   .
         string

   Description
         A textinfo, about the current available option for the current viewed page


.. container:: table-row

   Marker
         CURRENTPAGEPROZESSTITLE

   .
         string

   Description
         The title of the current viewed page


.. container:: table-row

   Marker
         COOKIEINFOSECTION

   .
         string

   Description
         If cookie is enabled it will be shown here


.. container:: table-row

   Marker
         COOKIEINFO

   .
         string

   Description
         Shows a textinfo, that cookie couldn't be set/read


.. container:: table-row

   Marker
         VIEWCOLLECTIONINFOSECTION

   .
         string

   Description
         Shows info about the summary or emptiness of the collection


.. container:: table-row

   Marker
         COLLECTIONINFO

   .
         string

   Description
         Will show the summary of the collection in a short textinfo


.. container:: table-row

   Marker
         VIEWCOLLECTIONTOOLBARLISTSECTION

   .
         string

   Description
         Section to show a list of pages in collection


.. container:: table-row

   Marker
         VIEWCOLLECTIONLISTSECTION

   .
         string

   Description
         Section to show a second list of pages in collection


.. container:: table-row

   Marker
         PROZESSDELETE

   .
         string

   Description
         Button to handle the collection (delete)


.. container:: table-row

   Marker
         PROZESSMOVEUP

   .
         string

   Description
         Button to handle the collection (moveup)


.. container:: table-row

   Marker
         PROZESSMOVEDOWN

   .
         string

   Description
         Button to handle the collection (movedown)


.. container:: table-row

   Marker
            PAGELINK

   .
         string

   Description
         Shows the pagetitle wrapped in a link


.. container:: table-row

   Marker
         PAGETITLE

   .
         string

   Description
         Shows only the pagetitle


.. container:: table-row

   Marker
         PAGECONTENT

   .
         string

   Description
         A placeholder to wrap it with some content defined via TypoScript (plugin.tx_eepcollect_pi1.display.pagecontent_stdWrap)


.. container:: table-row

   Marker
         VIEWCOLLECTIONLINKSECTION

   .
         string

   Description
         Section to show some further links for collection handling


.. container:: table-row

   Marker
         VIEWCOLLECTIONLINK

   .
         string

   Description
         Shows a link to the resultlistpage, as choosen in the plugin


Single markers (no sections)
""""""""""""""""""""""""""""


.. container:: table-row

   Marker
         COLLECTIONSMARTLIST

   .
         string

   Description
         Can be used to build an HMENU with TSSetup: stdWrap.setCurrent =1


.. container:: table-row

   Marker
         WHATISPAGECOLLECT

   .
         string

   Description
         Link to any page which contain information about this tool


.. ###### END~OF~TABLE ######

