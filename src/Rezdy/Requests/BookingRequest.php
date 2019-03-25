<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the BookingRequest resource
 *
 * @package Resources
 * @author Brad Ploeger
 */
class BookingRequest extends BaseRequest {	

	public function __construct($params = '') {
		
		//Set the optional properties of the object and the required datatype
		$this->optionalParams = [	"comments"			=> "string",
    								"commission"		=> "numeric",
    								"coupon"			=> "string",
    								"dateConfirmed"		=> "date-time",
								    "dateCreated"		=> "date-time",
								    "datePaid"			=> "date-time",
								    "dateReconciled"	=> "date-time",
								    "dateUpdated"		=> "date-time",
								    "internalNotes"		=> "string",
								    "orderNumber"		=> "string",
    								"paymentOption"		=> "enum-online-payment-options",
    								"resellerAlias"		=> "string",
								    "resellerComments"	=> "string",
								    "resellerId"		=> "integer",
								    "resellerName"		=> "string",
								    "resellerReference"	=> "string",
								    "resellerSource"	=> "enum-source",
								    "sendNotifications"	=> "boolean",
								    "source"			=> "enum-source",
								    "sourceChannel"		=> "string",
								    "sourceReferrer"	=> "string",
								    "status"			=> "enum-status",
								    "supplierAlias"		=> "string",
								    "supplierId"		=> "integer",
								    "supplierName"		=> "string",
								    "surcharge"			=> "numeric",
								    "totalAmount"		=> "numeric",
								    "totalCurrency"		=> "enum-currency-types",
								    "totalDue"			=> "numeric",
								    "totalPaid"			=> "numeric"
								];	

		// Sets the class mapping for single set items to the request 
		$this->setClassMap = 	[ 	'Rezdy\Requests\BookingCreatedBy' 		=> 'createdBy', 
									'Rezdy\Requests\BookingCreditCard'  	=> 'creditCard',
									'Rezdy\Requests\BookingCustomer' 		=> 'customer',
									'Rezdy\Requests\BookingResellerUser' 	=> 'resellerUser'
								]; 

		//Sets the class mapping for multiple item sets to the request 				
		$this->addClassMap  = 	[	'Rezdy\Requests\BookingField'			=> 'fields',
									'Rezdy\Requests\BookingItem'			=> 'items',
									'Rezdy\Requests\BookingPayment'			=> 'payments',
									'Rezdy\Requests\BookingVoucher'			=> 'vouchers'
								];	

		if (is_array($params)) {
			$this->buildFromArray($params);
		}
	}

	/* Verifies the request has the minimum amount of information
	*  to save a booking.  In Rezdy, a booking requires at a minimum,
	*  a customer and at least one item.
	*/
	public function isValidBooking() {
		return (isset($this->items) && isset($this->customer));		
	}
}