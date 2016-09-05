

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


Resultlistview
^^^^^^^^^^^^^^

If you choose viewmode 'resultview' for the plugin, it will show a list of the pages from the collection.
The plugintemplate substitutes a 'uid' out to the marker ###PAGECONTENT####.
This uid is used to generate the content from these pages by the following TypoScript Setup code: ::

	# resultlistview with appended pagecontent from col=0 (normal)
	plugin.tx_eepcollect_pi1.display.pagecontent_stdWrap.stdWrap {
		setContentToCurrent = 1
		cObject = COA
		cObject {
			wrap = |
			10 < styles.content.get
			10.select.pidInList.data = current:1
		}
	}

