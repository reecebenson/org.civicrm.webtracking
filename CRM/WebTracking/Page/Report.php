<?php

class CRM_WebTracking_Page_Report extends CRM_Core_Page {

  public function run() {
  	CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.webtracking', 'css/EmbedAPI/main.css');
  	CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.webtracking', 'css/EmbedAPI/components/flex-grid.css');
  	CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.webtracking', 'css/EmbedAPI/components/dashboard.css');
  	CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.webtracking', 'css/EmbedAPI/components/titles.css');
  	CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.webtracking', 'css/EmbedAPI/components/active-users.css');
  	CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.webtracking', 'css/EmbedAPI/components/view-selector.css');
    CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.webtracking', 'css/EmbedAPI/components/date-range-selector.css');

  	CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.webtracking', 'js/Report/GaApiMain.js', 6, 'page-body');
  	CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.webtracking', 'js/Report/ActiveUsers.js', 7, 'page-body');
  	CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.webtracking', 'js/Report/DateRangeSelector.js', 8, 'page-body');
  	CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.webtracking', 'js/Report/Dashboard.js', 9, 'page-body');
  	return parent::run();
  }	
}