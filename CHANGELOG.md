17-04-19 JKummer

	v2.0.0
	* Compatibility for TYPO3 9.5
	* Force no cache (USER_INT)
	* Moved typoscript to standard configuration folder, renamed to *.typoscript
	* Moved templates to standard template folder
	* Moved image resources to standard image folder
	* Removed Powermail example templates
	* Remove default page content rendering in result list view

17-10-18 JKummer

	v1.0.21
	* Locallang fix

22-07-17 JKummer

	v1.0.20
	* Composer validation

17-07-14 JKummer

	v1.0.19
	* TYPO3 v.8.7 compatibility

16-09-05 JKummer

	v1.0.18
	* TYPO3 v.7.6 compatibility

16-03-05 JKummer

	v1.0.17
	* improve GET param handling, ignore unexpectedly values
	* bugfix #69300, thx to Preben Rather Soerensen

15-06-19 JKummer

	v1.0.16
	* minor bugfix #67624, thx to Wolfgang Medicus

15-05-27 JKummer

	v1.0.15
	* adjust locallang
	* adjust documentation

15-05-05 JKummer

	* changed TYPO3 v.7.2 compatibility

14-10-27 Preben R. Soerensen  <preben et rather dot dk>

	* convert locallang to xliff
	* convert documentation to ReST

14-07-12 JKummer

	v1.0.14
	* changed TYPO3 v.6.2 compatibility

13-05-03 JKummer

	* bugfix: Incompatible with 6.0 due to t3lib_div::intInRange, thx to Peter Schuhmann at DynamicLines

12-08-03 JKummer

	* bugfix #39322: Incompatible with 4.7 due to t3lib_div::view_array

10-11-16 JKummer

	* bugfix #10723, DB-Update depend on identifyMode

10-09-24 JKummer

	* add marker for pageURL, feature #9893 thx to Falko Trojahn

10-09-20 JKummer

	* bugfix: pageLink with simulateStaticDocuments

10-07-30 JKummer

	* add frontend user identification
	* add german documentation
	* add constant editing
	* add settings in flexform

09-12-09 JKummer

	* activate caching using cHash

09-07-17 JKummer

	* bugfix: simplify replacements for templateCodes
	  ('str_replace' insted of 'ereg_replace')

09-07-15 JKummer

	* add view of rootline to pagetitles (with TS-Setup settings)
	* add use of PAGEID Markers to use in forms (powermail)
	* add view_mode settings to TypoScript setup

08-11-17 JKummer

	* add table for sessions and collection

08-04-19 JKummer

	* fixed security bug: strip_tags() funktion added for $_COOKIE
	* staticFile was 2times at different locations, cleared
	* added a clearAll funktion
	* changed some translations
	* add view-conditions depends on count of collected pages

08-03-03 JKummer

	* Initial release