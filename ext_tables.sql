#
# Table structure for table 'tx_eepcollect_sessions'
#

CREATE TABLE tx_eepcollect_sessions (
  uid int(11) NOT NULL auto_increment,
  pid int(11) DEFAULT '0' NOT NULL,
  ses_id varchar(32) NOT NULL default '',
  feuser_id varchar(32) NOT NULL default '',
  ses_tstamp int(11) unsigned NOT NULL default '0',
  ses_data text NOT NULL,
  PRIMARY KEY (uid),
  KEY parent (pid),
);
