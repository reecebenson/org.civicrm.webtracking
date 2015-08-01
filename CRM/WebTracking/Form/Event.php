<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.6                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2015                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
 */

/**
 * This class generates form components for processing Event Web Tracking
 */
class CRM_WebTracking_Form_Event extends CRM_Event_Form_ManageEvent {

  /**
   * Set variables up before form is built.
   *
   * @return void
   */
  public function preProcess() {
    CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.webtracking', 'css/web-tracking-form.css');
    parent::preProcess();
  }

  /**
   * Set default values for the form
   *
   * @return void
   */
  public function setDefaultValues() {
    $params['page_id']=$this->_id;
    $params['page_category']="civicrm_event";
    $defaults = array();
    CRM_WebTracking_BAO_WebTracking::retrieve($params, $defaults);

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

    // Checkbox to ask whether or not to enable web tracking
    $this->addElement('checkbox', 'enable_tracking', ts('Enable web tracking'));

    // Text field to input the tracking id
    $this->add('text', 'tracking_id', ts('Tracking ID'));

    // Checkbox to ask whether or not to enable event tracking
    $this->addElement('checkbox', 'ga_event_tracking', ts('Enable event tracking'));

    // Checkbox to ask whether or not to track when the user visits the info page
    $this->addElement('checkbox', 'track_info', ts('Track visit to info page'));

    // Checkbox to ask whether or not to track when the user visits the registration page
    $this->addElement('checkbox', 'track_register', ts('Track visit to registration page'));

    // Checkbox to ask whether or not to track when the user visits the confirmation page
    $this->addElement('checkbox', 'track_confirm_register', ts('Track visit to confirmation page'));
    
    // Checkbox to ask whether or not to track when the user visits the thank you page
    $this->addElement('checkbox', 'track_thank_you', ts('Track visit to thank you page'));

    // Checkbox to ask whether or not to track when the user changes default price option
    $this->addElement('checkbox', 'track_price_change', ts('Track price change'));

    // Checkbox to ask whether or not to enable ecommerce tracking
    $this->addElement('checkbox', 'track_ecommerce', ts('Enable source tracking'));

    // Checkbox to ask whether the page is the primary page of the experiment 
    $this->addElement('checkbox', 'is_experiment', ts('Primary page of experiment'));

    // Text field to input the experiment key
    $this->add('text', 'experiment_id', ts('Experiment key'));

    $this->addFormRule(array('CRM_WebTracking_Form_Event', 'formRule'));

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

    if (isset($values['enable_tracking']) && $values['enable_tracking'] == 1) {
      // Checking that UAID provided by the customer has the string 'UA-' as its prefix
      $pos = strpos($values['tracking_id'],'UA-'); 
      if ($pos===false || $pos!==0) {
	      $errors['tracking_id'] = ts('Please provide a valid tracking id');
      }
    }

    if (isset($values['is_experiment']) && $values['is_experiment'] == 1) {
      if ($values['experiment_id'] == '') {
        $errors['experiment_id'] = ts('Please provide a valid experiment key');
      }
    }
    
    return $errors;
  }

  /**
   * Process the form submission.
   *
   * @return void
   */
  public function postProcess() {
    // TODO:: is this required?
    $params = $this->controller->exportValues($this->_name);

    $existParams['page_id'] = $this->_id;
    $existParams['page_category'] = "civicrm_event";
    $existingEnrty = array();
    
    CRM_WebTracking_BAO_WebTracking::retrieve($existParams, $existingEnrty);

    // Setting up the params array with the values obtained from the form 
    if (!empty($existingEnrty)) {
       $params['id'] = $existingEnrty['id']; 
    }
    $params['page_id'] = $this->_id;
    $params['page_category']="civicrm_event";

    $params['enable_tracking'] = CRM_Utils_Array::value('enable_tracking', $params, FALSE);
    $params['tracking_id'] = CRM_Utils_Array::value('tracking_id', $params, NULL);

    $params['ga_event_tracking'] = CRM_Utils_Array::value('ga_event_tracking', $params, FALSE);
    $params['track_info'] = CRM_Utils_Array::value('track_info', $params, FALSE);
    $params['track_register'] = CRM_Utils_Array::value('track_register', $params, FALSE);
    $params['track_confirm_register'] = CRM_Utils_Array::value('track_confirm_register', $params, FALSE);
    $params['track_thank_you'] = CRM_Utils_Array::value('track_thank_you', $params, FALSE);
    $params['track_price_change'] = CRM_Utils_Array::value('track_price_change', $params, FALSE);
    
    $params['track_ecommerce'] = CRM_Utils_Array::value('track_ecommerce', $params, FALSE);

    $params['is_experiment'] = CRM_Utils_Array::value('is_experiment', $params, FALSE);
    $params['experiment_id'] = CRM_Utils_Array::value('experiment_id', $params, NULL);

    // Updating the database with the new entry
    $event = CRM_WebTracking_BAO_WebTracking::add($params);
    parent::endPostProcess();
  }

  /**
   * Return a descriptive name for the page, used in wizard header
   *
   * @return string
   */
  public function getTitle() {
    return ts('Event Web Tracking Settings');
  }
}
