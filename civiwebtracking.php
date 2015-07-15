<?php

require_once 'civiwebtracking.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function civiwebtracking_civicrm_config(&$config) {
  _civiwebtracking_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function civiwebtracking_civicrm_xmlMenu(&$files) {
  _civiwebtracking_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function civiwebtracking_civicrm_install() {
  _civiwebtracking_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function civiwebtracking_civicrm_uninstall() {
  _civiwebtracking_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function civiwebtracking_civicrm_enable() {
  _civiwebtracking_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function civiwebtracking_civicrm_disable() {
  _civiwebtracking_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function civiwebtracking_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _civiwebtracking_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function civiwebtracking_civicrm_managed(&$entities) {
  _civiwebtracking_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function civiwebtracking_civicrm_caseTypes(&$caseTypes) {
  _civiwebtracking_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function civiwebtracking_civicrm_angularModules(&$angularModules) {
_civiwebtracking_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function civiwebtracking_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _civiwebtracking_civix_civicrm_alterSettingsFolders($metaDataFolders);
}


/**
* Adds a new tab for configuring web tracking parameters
*/
function civiwebtracking_civicrm_tabset($tabsetName, &$tabs, $context) {

  // Check if the tab set is event manage
  if ($tabsetName == 'civicrm/event/manage') {

    if (!empty($context)) {
      $eventID = $context['event_id'];
      $url = CRM_Utils_System::url( 'civicrm/event/manage/webtracking',
        "reset=1&snippet=5&force=1&id=$eventID&action=update&component=event" );
      // Add a new WebTracking tab along with url 
      $tab['webtracking'] = array(
        'title' => ts('WebTracking'),
        'link' => $url,
        'valid' => 1,
        'active' => 1,
        'current' => false,
      );
    }
    else {
      $tab['webtracking'] = array(
        'title' => ts('WebTracking'),
        'url' => 'civicrm/event/manage/webtracking',
      );
    }
 
  //Insert this tab in the end  
  $tabs = array_merge($tabs,$tab);
  }
}

/**
* This hook is invoked when the event page is rendered
* Based on the web tracking parameters it invokes certain javascript/jquery functions which talk to google analytics
*/

function civiwebtracking_civicrm_pageRun(&$page) {
  $pageName = $page->getVar('_name');
  if ($pageName == 'CRM_Event_Page_EventInfo') {   
    $trackingParams = array('page_id' => $page->getVar('_id'), 'page_category' => "civicrm_event");
    CRM_Civiwebtracking_BAO_WebTracking::retrieve($trackingParams,$trackingValues);

    if($trackingValues['enable_tracking'] == 1) {
      // General script for web tracking
      CRM_Core_Resources::singleton()->addVars('WebTracking', array('tracking_id' => $trackingValues['tracking_id']));
      CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.module.civiwebtracking', 'js/WebTracking.js',10,'html-header');

      if($trackingValues['is_experiment'] == 1) {
        // Script for the experiment
        CRM_Core_Resources::singleton()->addVars('WebTracking', array('experiment_id' => $trackingValues['experiment_id']));
        CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.module.civiwebtracking', 'js/Experiment.js',11,'html-header');
        CRM_Core_Resources::singleton()->addScript("utmx('url','A/B');",12,'html-header');
        CRM_Core_Resources::singleton()->addScript("ga('send', 'pageview');",13,'html-header');
      }
      else
        CRM_Core_Resources::singleton()->addScript("ga('send', 'pageview');",11,'html-header');

      // Script for event tracking
      CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.module.civiwebtracking', 'js/EventTracking.js');

      // Appropriate js function call if track_register is enabled 
      if ($trackingValues['track_register'] == 1)
        CRM_Core_Resources::singleton()->addScript('trackRegister();');

      // Saving the utm source in the session variable if track_ecommerce is enabled
      if($trackingValues['track_ecommerce'] == 1) {
        $session = CRM_Core_Session::singleton();
        if(isset($_GET['utm_source'])) 
          $session->set('utm_source',$_GET['utm_source']);
        else 
          $session->set('utm_source','general');
      }  
    }
  }
}

/**
* This hook is invoked when the 'confirm register' and 'thank you' form is rendered
* Based on the web tracking parameters it invokes certain javascript/jquery functions which talk to google analytics
*/
function civiwebtracking_civicrm_buildForm($formName, &$form) {

  $eventFormNames = array('CRM_Event_Form_Registration_Register', 'CRM_Event_Form_Registration_ThankYou', 'CRM_Event_Form_Registration_Confirm');
  if (in_array($formName, $eventFormNames)) {

    $trackingParams = array('page_id' => $form->_eventId, 'page_category' => "civicrm_event");
    CRM_Civiwebtracking_BAO_WebTracking::retrieve($trackingParams,$trackingValues);
    if ($trackingValues['enable_tracking'] == 1) {
      // General script for web tracking
      CRM_Core_Resources::singleton()->addVars('WebTracking', array('tracking_id' => $trackingValues['tracking_id']));
      CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.module.civiwebtracking', 'js/WebTracking.js',10,'html-header');

      // Script for event tracking
      CRM_Core_Resources::singleton()->addScriptFile('org.civicrm.module.civiwebtracking', 'js/EventTracking.js');
    }
    else 
      return;

    if ($formName == 'CRM_Event_Form_Registration_Register') {
      if($form->_values['event']['is_monetary'] == 1) {
        CRM_Core_Resources::singleton()->addScript('trackPriceChange();');  
      }
    }

    else if ($formName == 'CRM_Event_Form_Registration_ThankYou') {
        CRM_Core_Resources::singleton()->addVars('WebTracking', array('trnx_id' => $form->_trxnId, 'totalAmount' => $form->_totalAmount));
        // Fetching the source from the session and adding it as a variable.
        $session = CRM_Core_Session::singleton();
        CRM_Core_Resources::singleton()->addVars('WebTracking', array('utm_source' => $session->get('utm_source')));
        if ($form->_trxnId)
          CRM_Core_Resources::singleton()->addScript('trackEcommerce();');
    }

    else if ($formName == 'CRM_Event_Form_Registration_Confirm') {
      CRM_Core_Resources::singleton()->addScript('trackConfirmRegister();');
    }    
  } 
}

/**
* This hook is used to add the web tracking report link to the navigation menu
*
*/
function civiwebtracking_civicrm_navigationMenu(&$params) {
 
  // Check that our item doesn't already exist
  $menu_item_search = array('url' => 'civicrm/report/webtracking');
  $menu_items = array();
  CRM_Core_BAO_Navigation::retrieve($menu_item_search, $menu_items);
 
  if ( ! empty($menu_items) ) { 
    return;
  }
 
  $navId = CRM_Core_DAO::singleValueQuery("SELECT max(id) FROM civicrm_navigation");
  if (is_integer($navId)) {
    $navId++;
  }
  // Find the Report menu
  $reportID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_Navigation', 'Reports', 'id', 'name');

  $params[$reportID]['child'][$navId] = array (
    'attributes' => array (
      'label' => ts('Web Tracking Report',array('domain' => 'org.civicrm.module.civiwebtracking')),
      'name' => 'Web Tracking Report',
      'url' => 'civicrm/report/webtracking',
      'permission' => 'access CiviReport,access CiviEvent',
      'operator' => 'OR',
      'separator' => 1,
      'parentID' => $reportID,
      'navID' => $navId,
      'active' => 1
    )   
  );  
}