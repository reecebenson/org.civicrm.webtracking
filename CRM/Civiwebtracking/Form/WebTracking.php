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
class CRM_Civiwebtracking_Form_WebTracking extends CRM_Event_Form_ManageEvent {

  /**
   * Set variables up before form is built.
   *
   * @return void
   */
  public function preProcess() {
    CRM_Core_Resources::singleton()->addStyleFile('org.civicrm.module.civiwebtracking', 'css/webTrackingForm.css');
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
    CRM_Civiwebtracking_BAO_WebTracking::retrieve($params,$defaults);

    $this->_showHide = new CRM_Core_ShowHideBlocks();

    if(empty($defaults)) {
      // When the values have not been set previosuly, hide the tracking params and the experiment id text field
      $this->_showHide->addHide('webtracking-params');
      $this->_showHide->addHide('experiment-id');
    }
    else if (!$defaults['enable_tracking']) {
      // When webtracking is disabled, hide the tracking params
      $this->_showHide->addHide('webtracking-params');
      if(!$defaults['is_experiment'])
        $this->_showHide->addHide('experiment-id');  
    }  
    else if(!$defaults['is_experiment']){
      // When webtracking is enabled but page is not the primary page of an experiment, hide the experiment id
      $this->_showHide->addHide('experiment-id');
    }  
    $this->_showHide->addToTemplate();

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
    $this->addElement('checkbox', 'enable_tracking', ts('Enable Web Tracking'));

    // Text field to input the tracking id
     $this->add('text', 'tracking_id', ts('Tracking ID'));

    // Checkbox to ask whether or not to track when the user clicks on register
    $this->addElement('checkbox', 'track_register', ts('Track Click On Register'));

    // Checkbox to ask whether or not to track when the user changes default price option
    $this->addElement('checkbox', 'track_price_change', ts('Track Price Change'));

    // Checkbox to ask whether or not to track when the user clicks on confirm register
    $this->addElement('checkbox', 'track_confirm_register', ts('Track Click On Confirm Register'));

    // Checkbox to ask whether or not to enable ecommerce tracking
    $this->addElement('checkbox', 'track_ecommerce', ts('Enable Ecommerce Tracking'));

    // Checkbox to ask whether the page is the primary page of the experiment 
    $this->addElement('checkbox', 'is_experiment', ts('Primary Page Of Experiment'), NULL,
      array('onclick' => "return showHideByValue('is_experiment','','experiment-id','table-row','radio',false);"));

    // Text field to input the experiment id
    $this->add('text', 'experiment_id', ts('Experiment ID'));

    $this->addFormRule(array('CRM_Civiwebtracking_Form_WebTracking', 'formRule'));

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

    if(isset($values['enable_tracking']) && $values['enable_tracking'] == 1)
    {
      // Checking that UAID provided by the customer has the string 'UA-' as its prefix
      $pos = strpos($values['tracking_id'],'UA-'); 
      if($pos===false || $pos!==0) $errors['tracking_id'] = ts('You have selected to enable web tracking, please provide a valid tracking id');
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
    
    CRM_Civiwebtracking_BAO_WebTracking::retrieve($existParams,$existingEnrty);

    // Setting up the params array with the values obtained from the form 
    if(!empty($existingEnrty))
    {
       $params['id'] = $existingEnrty['id']; 
    }
    $params['page_id'] = $this->_id;
    $params['page_category']="civicrm_event";
    $params['enable_tracking'] = CRM_Utils_Array::value('enable_tracking', $params, FALSE);
    $params['tracking_id'] = CRM_Utils_Array::value('tracking_id', $params, NULL);
    $params['track_register'] = CRM_Utils_Array::value('track_register', $params, FALSE);
    $params['track_price_change'] = CRM_Utils_Array::value('track_price_change', $params, FALSE);
    $params['track_confirm_register'] = CRM_Utils_Array::value('track_confirm_register', $params, FALSE);
    $params['track_ecommerce'] = CRM_Utils_Array::value('track_ecommerce', $params, FALSE);
    $params['is_experiment'] = CRM_Utils_Array::value('is_experiment', $params, FALSE);
    $params['experiment_id'] = CRM_Utils_Array::value('experiment_id', $params, NULL);

    // Updating the database with the new entry
    $event = CRM_Civiwebtracking_BAO_WebTracking::add($params);

    if ($this->_action & CRM_Core_Action::ADD) {
      $url = 'civicrm/event/manage/webtracking';
      $urlParams = "action=update&reset=1&id={$event->id}";
      // special case for 'Save and Done' consistency.
      if ($this->controller->getButtonName('submit') == '_qf_EventInfo_upload_done') {
        $url = 'civicrm/event/manage';
        $urlParams = 'reset=1';
        CRM_Core_Session::setStatus(ts("'%1' information has been saved.",
          array(1 => $this->getTitle())
        ), ts('Saved'), 'success');
      }

      CRM_Utils_System::redirect(CRM_Utils_System::url($url, $urlParams));
    }

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
