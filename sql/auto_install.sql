DROP TABLE IF EXISTS `civicrm_webtracking`;

-- /*******************************************************
-- *
-- * civicrm_webtracking
-- *
-- * This table will hold web tracking parameters for event and contribution pages.
-- *
-- *******************************************************/
CREATE TABLE `civicrm_webtracking` (


     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Serial No.',
     `page_id` int unsigned NOT NULL   COMMENT 'Holds the id of the Event/Contribution page',
     `page_category` varchar(64) NOT NULL   COMMENT 'Denotes whether the page is an event page or a contribution page',
     `enable_tracking` tinyint   DEFAULT 0 COMMENT 'Denotes whether webtracking is enabled or not',
     `tracking_id` varchar(64)    COMMENT 'Unique UAID provided by google analytics',
     `track_register` tinyint   DEFAULT 0 COMMENT `Track the event of user clicking on the register button`,
     `track_price_change` tinyint   DEFAULT 0 COMMENT `Track the event of user changing the default price option`,
     `track_confirm_register` tinyint   DEFAULT 0 COMMENT `Track the event of user clicking on the confirm register button`,
     `track_ecommerce` tinyint   DEFAULT 0 COMMENT `Denotes whether ecommerce tracking is enabled or not`,
     `is_experiment` tinyint   DEFAULT 0 COMMENT `Denotes whether the page is the primary page of a google analytics experiment`,
     `experiment_id` varchar(64)    COMMENT 'Unique experiment ID provided by google analytics',
,
    PRIMARY KEY ( `id` )
  
)  ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci  ;