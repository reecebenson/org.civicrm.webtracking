<?php

class CRM_Civiwebtracking_Page_Report extends CRM_Core_Page {

  public function run() {
  	CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.module.civiwebtracking', 'css/EmbedAPI/main.css');
  	CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.module.civiwebtracking', 'css/EmbedAPI/components/flex-grid.css');
  	CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.module.civiwebtracking', 'css/EmbedAPI/components/dashboard.css');
  	CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.module.civiwebtracking', 'css/EmbedAPI/components/titles.css');
  	CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.module.civiwebtracking', 'css/EmbedAPI/components/active-users.css');
  	CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.module.civiwebtracking', 'css/EmbedAPI/components/view-selector.css');
    CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.module.civiwebtracking', 'css/EmbedAPI/components/date-range-selector.css');

  	CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.module.civiwebtracking', 'js/ga-api-main.js', 6, 'page-body');
  	CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.module.civiwebtracking', 'js/active-users.js', 7, 'page-body');
  	CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.module.civiwebtracking', 'js/date-range-selector.js', 8, 'page-body');
  	CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.module.civiwebtracking', 'js/dashboard.js', 9, 'page-body');
  	return parent::run();
  }	
}