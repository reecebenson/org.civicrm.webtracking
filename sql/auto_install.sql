DROP TABLE IF EXISTS `civicrm_webtracking`;

-- /*******************************************************
-- *
-- * civicrm_webtracking
-- *
-- * This table will hold web tracking parameters for various pages.
-- *
-- *******************************************************/
CREATE TABLE `civicrm_webtracking` (


     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'WebTracking ID',
     `enable_tracking` tinyint   DEFAULT 0 COMMENT 'User chooses to enable web tracking or not?',
     `tracking_id` varchar(64)    COMMENT 'Unique UAID provided by google analytics.',
     `page_id` int unsigned NOT NULL   COMMENT 'Holds the id to the CiviEvent/CiviContribution/CiviDonation.',
     `page_category` varchar(64) NOT NULL   COMMENT 'Whether the Page this row refers to is a CiviEvent/CiviContribution/CiviDonation Page.' 
,
    PRIMARY KEY ( `id` )
 
 
 
)  ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci  ;