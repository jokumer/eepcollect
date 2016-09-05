

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


Upgrade
^^^^^^^

**1.0.5 to 1.0.6+**
"""""""""""""""""""

- Added 'Storage page' in Flexform (former only defined by TS). Check settings for general storage page in your typoscript settings that you will have the same in your flexformsettings. Otherwise existing collections will not be readable.
- Check settings for 'page link type' (pagetitle or rootline). The values has be changed, to avoid 'Null' in configurations.

