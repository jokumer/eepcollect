

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


HMENU
^^^^^

There is a marker called ###COLLECTIONSMARTLIST### that contains a comma separated list of page-uids, which are currently selected in the collection.
With these uids you can create your own HMENU objects like: ::

	myMenu = HMENU
	myMenu {
		special = list
		special.value = # ... comes from 'collectionsmartlist' see below
		1 = TMENU
		# ...
	}

	plugin.tx_eepcollect_pi1.display.collectionsmartlist_stdWrap.stdWrap {
		setContentToCurrent = 1
		cObject < myMenu
		cObject.special.data = current:1
	}

Its should also possible to use cookie directly to build a menu: ::

	myMenu.special.list.data = global:HTTP_COOKIE_VARS|tx_eepcollect_pi1
