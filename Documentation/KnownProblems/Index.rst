

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


Known problems
--------------


- It should not be possible to include a page that show collections into your collection. Otherwise, your server could run into error: Fatal error Allowed memory size of 123456789 bytes exhausted... You have two possibilities to avoid this:
	- You should exclude these pages from collections with TS: $plugin.tx_eepcollect_pi1.pidOfExcludedPages.
	- Choose another Template for these pages, where you will hide toolbar.

- No separation between languages (a selected page can be viewed in different languages but you can’t select pages detached by a specific language).

- When using Extension 'rgtabs' at same pages, which can be collected: each PAGECONTENT renders multiple included JS during use of tslib_fe->INTincScript()

- GET-Parameter '?tx_eepcollect_pi1[prozess]=' will be stored in table cache_pages, in indexed_search and also in public search machines as unique page.

- Please report bugs and features in forge: http://forge.typo3.org/projects/show/extension-eepcollect

