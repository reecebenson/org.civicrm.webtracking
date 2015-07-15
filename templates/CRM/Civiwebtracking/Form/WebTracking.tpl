{*
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
*}

<div class="crm-block crm-form-block crm-event-manage-webtracking-form-block">
  
  <div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="top"}
  </div>

  <table class="form-table-webtracking" border="8px">         

    <tr class="crm-event-manage-webtracking-form-block-enable_tracking" id="enable-tracking">
      <td>&nbsp;</td>
      <td>{$form.enable_tracking.html} {$form.enable_tracking.label}</td>
    </tr>

    <tbody id="webtracking-params">
      <tr class="crm-event-manage-webtracking-form-block-tracking_id">
          <td>{$form.tracking_id.label}</td>
          <td>{$form.tracking_id.html} </br></td>
      </tr>
      <tr class="crm-event-manage-eventinfo-form-block-track_register">
        <td>&nbsp;</td>
        <td>{$form.track_register.html} {$form.track_register.label}</td>
      </tr>
      <tr class="crm-event-manage-eventinfo-form-block-track_price_change">
        <td>&nbsp;</td>
        <td>{$form.track_price_change.html} {$form.track_price_change.label}</td>
      </tr>
      <tr class="crm-event-manage-eventinfo-form-block-track_confirm_register">
        <td>&nbsp;</td>
        <td>{$form.track_confirm_register.html} {$form.track_confirm_register.label}</td>
      </tr>
      <tr class="crm-event-manage-eventinfo-form-block-track_ecommerce">
        <td>&nbsp;</td>
        <td>{$form.track_ecommerce.html} {$form.track_ecommerce.label}</td>
      </tr>
      <tr class="crm-event-manage-eventinfo-form-block-is_experiment">
        <td>&nbsp;</td>
        <td>{$form.is_experiment.html} {$form.is_experiment.label}</td>
      </tr> 
      <tr class="crm-event-manage-eventinfo-form-block-experiment_id" id="experiment-id">
        <td>{$form.experiment_id.label}</td>
        <td>{$form.experiment_id.html} </br></td>
      </tr>
    </tbody>
  </table>  

  <div class="crm-submit-buttons">
     {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>

</div>

{include file="CRM/common/showHide.tpl"}

{literal}
<script type="text/javascript">
cj(document).ready(function(){
      cj('#enable_tracking').change(function() {
        cj('#webtracking-params').toggle();
      });
});    
</script>
{/literal}

