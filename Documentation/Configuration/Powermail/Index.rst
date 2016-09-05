.. include:: Images.txt

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


Include collection in forms, using Powermail v1.
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

To use collections in HTML-forms (for example to build an orderform) this extension offers a way, using it in powermail (until v1.x).

Since powermail v.2.0 it doesnt works, as espected. Maybe someone find a solution and want to publish it.

There are two example templates inside the template folder (for checkboxes and as a selectbox).


Example (Checkbox)
""""""""""""""""""

**HTML-Template:** ::

	<!-- ###COLLECTDISPLAY_RESULTLIST### begin -->
		<!-- ###VIEWCOLLECTIONTOOLBARLISTSECTION### begin -->
			<input type="checkbox" id="uid321" name="tx_powermail_pi1[uid321][###PAGEID###]" value="###PAGETITLE###" />###PAGETITLE###<br />
		<!-- ###VIEWCOLLECTIONTOOLBARLISTSECTION### end -->
	<!-- ###COLLECTDISPLAY_RESULTLIST### end -->


**TypoScript:** ::

	# eepcollect in powermail
	lib.powermailCheckbox_eepcollect < plugin.tx_eepcollect_pi1
	lib.powermailCheckbox_eepcollect {
		userFunc = tx_eepcollect_pi1->maintemplateFile = EXT:eepcollect/template/eepcollect_powermail_checkbox.tmpl
		default_view_mode = view_list_mode
		pid_list = 123
	}

**Plugin powermail settings:**

Use in your fieldset for your field a fieldtype called 'Add typoscript object' and in 'Typoscript object' settings write the name of your typoscript object called ' *lib.powermailCheckbox_eepcollect* '.

Important! Compare the uids for pid_list (123) and powermail-field (321) with your real ones in templatefile and typoscript.


|img-6|

*Powermail v1.x*