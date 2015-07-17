
function trackRegister() {
	CRM.$(function($) {
		$(".action-link.section.register_link-section.register_link-bottom").on('click', function(event) {
			ga('send', 'event', 'Register', 'click');
		});		
		$(".action-link.section.register_link-section.register_link-top").on('click', function(event) {
			ga('send', 'event', 'Register', 'click');
		});
	});
}

function trackPriceChange() {
	CRM.$(function($) {
		$("div[class^='price-set-row']").on('click', function(event) {
			var id = event.target.id;
			if ($("#"+ id).is(':checked')) {
				var eventString = "Selected " + $("#"+id).attr('data-amount') + " " + $("#"+id).attr('data-currency');
				ga('send', 'event', eventString, 'click');	
			}	
		});
	});
}

function trackConfirmRegister() {
	CRM.$(function($) {
		$(".crm-submit-buttons").on('click', function(event) {
			ga('send', 'event', 'Confirm Register', 'click');
		});
	});	
}

function trackEcommerce() {
	var trnxId = CRM.vars.WebTracking.trnx_id;
	var totalAmount = CRM.vars.WebTracking.totalAmount;
	var source = CRM.vars.WebTracking.utm_source;

	ga('require', 'ecommerce');
	ga('ecommerce:addTransaction', {
			'id': trnxId,                     // Transaction ID. Required.
			'affiliation': source,   		  		// Affiliation or store name.
			'revenue': totalAmount,           // Grand Total.
			'shipping': '0',                  // Shipping.
			'tax': '0'                     	  // Tax.
	});
	ga('ecommerce:send');
}

function trackViewRegistration() {
	CRM.$(function($) {
		if ($("#errorList li").length == 0) {
			ga('send', 'event', 'Viewed Resistration Page', 'click');	
		}
	});
}
