/*
 *
 *  Copyright (c) 2017. - Stranger Studios, LLC - Thomas Sjolshagen <thomas@eighty20results.com>
 *  ALL RIGHTS RESERVED
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

// some vars for keeping track of whether or not we show billing
var pmpro_gateway_billing;
var pmpro_pricing_billing;

// this var is used by several pmpro add ons to keep track of whether or not the billing fields are required
if ( pmpro_require_billing == null ) {
	var pmpro_require_billing = true;
}

// keep track of our obect
var PMProVariablePricing;

// this script will hide show billing fields based on the price set
jQuery( document ).ready(
	function() {
		"use strict";
		PMProVariablePricing = {
			init: function() {

				// setup these global vars
				pmpro_gateway_billing = pmprovp.settings.gateway_billing;
				pmpro_pricing_billing = pmprovp.settings.pricing_billing;

				// some vars
				this.no_billing_gateways = ['paypalstandard', 'paypalexpress', 'twocheckout', 'check'];
				this.priceElem           = jQuery( '#price' );
				this.addressFields       = jQuery( '#pmpro_billing_address_fields' );
				this.paymentInfo         = jQuery( '#pmpro_payment_information_fields' );
				this.paymentMethod       = jQuery( '#pmpro_payment_method' );
				this.regSubmitSpan       = jQuery( '#pmpro_submit_span' );
				this.ppeSubmitSpan       = jQuery( '#pmpro_paypalexpress_checkout' );

				// bind check to price field
				this.price_timer = null;
				this.priceElem.bind(
					'keyup change', function() {
						// use our global var name here, since we're in a closure
						PMProVariablePricing.price_timer = setTimeout( PMProVariablePricing.checkForFree, 500 );
					}
				);

				// get gateway value and bind check to gateway field
				if (typeof this.paymentMethod == 'object') {
					this.gateway = jQuery( 'input[name=gateway]:checked' ).val();
					jQuery( 'input[name=gateway]' ).bind(
						'click', function() {
							// use our global var name here, since we're in a closure
							PMProVariablePricing.price_timer = setTimeout( PMProVariablePricing.checkForFree, 500 );
						}
					);
				} else {
					this.gateway = pmprovp.settings.gateway;
				}

				// check when page loads too
				this.checkForFree();
			},
			checkForFree: function() {

				// get the current price
				var price = parseFloat( PMProVariablePricing.priceElem.val() );
				if (price > 0) {
					pmpro_pricing_billing = true;
				} else {
					pmpro_pricing_billing = false;
				}

				// if there is a payment method radio, get the current gateway
				if (typeof PMProVariablePricing.paymentMethod == 'object') {
					PMProVariablePricing.gateway = jQuery( 'input[name=gateway]:checked' ).val();

					// some gateways require billing fields, others don't
					if (PMProVariablePricing.no_billing_gateways.indexOf( PMProVariablePricing.gateway ) > -1) {
						pmpro_gateway_billing = false;
					} else {
						pmpro_gateway_billing = true;
					}
				}

				// figure out if we should show the billing fields
				if (pmpro_gateway_billing && pmpro_pricing_billing) {
					PMProVariablePricing.addressFields.show();
					PMProVariablePricing.paymentInfo.show();
					pmpro_require_billing = true;
				} else {
					PMProVariablePricing.addressFields.hide();
					PMProVariablePricing.paymentInfo.hide();
					PMProVariablePricing.paymentMethod.hide();
					pmpro_require_billing = false;
				}

				// toggle the payment method box if available and which type of checkout button shown
				if (pmpro_pricing_billing) {
					PMProVariablePricing.paymentMethod.show();
					if (PMProVariablePricing.gateway == 'paypalexpress' || PMProVariablePricing.gateway == 'paypalstandard') {
						PMProVariablePricing.regSubmitSpan.hide();
						PMProVariablePricing.ppeSubmitSpan.show();
					} else {
						PMProVariablePricing.ppeSubmitSpan.hide();
						PMProVariablePricing.regSubmitSpan.show();
					}
				} else {
					PMProVariablePricing.ppeSubmitSpan.hide();
					PMProVariablePricing.regSubmitSpan.show();
				}
			}
		}

		PMProVariablePricing.init();
	}
);
