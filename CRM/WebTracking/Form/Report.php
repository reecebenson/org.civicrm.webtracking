<?php

class CRM_WebTracking_Form_Report extends CRM_Core_Form {

  /**
   * Set variables up before form is built.
   *
   * @return void
   */
  public function preProcess() {
    CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.webtracking', 'css/web-tracking-report-form.css');

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
    parent::preProcess();
  }

  /**
   * Set default values for the form
   *
   * @return void
   */
  public function setDefaultValues() {
    $defaults = array(); 
    $defaults['web_tracking_report_id'] = civicrm_api3('setting', 'getValue', array('group' => 'Web Tracking', 'name' => 'web_tracking_report_id'));
    CRM_Core_Resources::singleton()->addVars('WebTracking', array('web_tracking_report_id' => $defaults['web_tracking_report_id']));
    return $defaults;
  }

  /**
   * Build the form object.
   *
   * @return void
   */
  public function buildQuickForm() {

    // TODO:: Is this required?
    $this->applyFilter('__ALL__', 'trim');

    // Text field to input the client ID
    $this->add('text', 'web_tracking_report_id', ts('Client ID'));

    $this->addFormRule(array('CRM_WebTracking_Form_Report', 'formRule'));

    $buttons = array(
        array(
          'type' => 'upload',
          'name' => ts('Save'),
          'isDefault' => TRUE,
        )
    );
    $this->addButtons($buttons);

    parent::buildQuickForm();
  }

  /**
   * Global validation rules for the form.
   *
   * @param array $values
   *
   * @return array
   *   list of errors to be posted back to the form
   */
  public static function formRule($values) {
    $errors = array();
    if (!(isset($values['web_tracking_report_id']) && strlen($values['web_tracking_report_id']) > 0)) {
      $errors['web_tracking_report_id'] = "Please enter a valid client id";
    }
    return $errors;
  }

  /**
   * Process the form submission.
   *
   * @return void
   */
  public function postProcess() {

    $params = $this->controller->exportValues($this->_name);
    $params['web_tracking_report_id'] = CRM_Utils_Array::value('web_tracking_report_id', $params, NULL);

    civicrm_api3('setting', 'create', array('sequential' => 1, 'web_tracking_report_id' => $params['web_tracking_report_id']));

    $url = 'civicrm/report/webtracking';
    $urlParams = 'action=update&reset=1';
    CRM_Utils_System::redirect(CRM_Utils_System::url($url, $urlParams));
  }

  /**
   * Return a descriptive name for the page, used in wizard header
   *
   * @return string
   */
  public function getTitle() {
    return ts('Web Tracking Report');
  }
}