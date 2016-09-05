

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


Toolbar View
^^^^^^^^^^^^

A toolbar to add different pages to a virtual collection, should be available on different pages. Therefore, it would be a good idea to setup the plugin with the toolbar, into a preferred place on each page that you want to collect. Choose a dynamic way to do this (like page.10.subparts.pagecollectortoolbar).

Create or use a page in your pagetree (it can be a sysfolder), where you just store some contentelements, which you will use in different ways and places. Create a contentelement with the type of 'insert plugin', where you select the plugin to insert. Choose 'toolbar' as viewmode. Save.

Then you can setup this toolbar on each page you wish by using these TypoScript-Setup settings: ::

	page.10.subparts.pagecollectortoolbar = CONTENT
	page.10.subparts.pagecollectortoolbar {
	 	table = tt_content
	 	select {
			# the pid of the page, where
			pidInList =
			# uid of the contentelemnt which holds the plugin with viewmode toolbar
			uidInList =
	 	}
	 }

You should have a subpart called: 'pagecollectortoolbar' or find any other subpart to put in this element. The toolbar will work on each page, and will show the options to add, delete or move the current viewed page in the collection.
