<?php
 namespace Rezdy\Requests;
 
/**
 * Creates and verifies the BookingRequest resource
 *
 * @package Resources
 * @author Brad Ploeger
 */
class Booking extends BaseRequest implements RequestInterface {	

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
    								"paymentOption"		=> "enum.online-payment-options",
    								"resellerAlias"		=> "string",
								    "resellerComments"	=> "string",
								    "resellerId"		=> "integer",
								    "resellerName"		=> "string",
								    "resellerReference"	=> "string",
								    "resellerSource"	=> "enum.source",
								    "sendNotifications"	=> "boolean",
								    "source"			=> "enum.source",
								    "sourceChannel"		=> "string",
								    "sourceReferrer"	=> "string",
								    "status"			=> "enum.status",
								    "supplierAlias"		=> "string",
								    "supplierId"		=> "integer",
								    "supplierName"		=> "string",
								    "surcharge"			=> "numeric",
								    "totalAmount"		=> "numeric",
								    "totalCurrency"		=> "enum.currency-types",
								    "totalDue"			=> "numeric",
								    "totalPaid"			=> "numeric"
								];	

		// Sets the class mapping for single set items to the request 
		$this->setClassMap = [ 	'Rezdy\Requests\Objects\CreatedBy' 				=> 'createdBy', 
								'Rezdy\Requests\Objects\CreditCard'  			=> 'creditCard',
								'Rezdy\Requests\Customer' 						=> 'customer',
								'Rezdy\Requests\Objects\BookingResellerUser'	=> 'resellerUser'
							 ]; 

		//Sets the class mapping for multiple item sets to the request 				
		$this->addClassMap  = [	'Rezdy\Requests\Objects\Field'			=> 'fields',
								'Rezdy\Requests\Objects\BookingItem'	=> 'items',
								'Rezdy\Requests\Objects\BookingPayment'	=> 'payments',
								'Rezdy\Requests\Objects\BookingVoucher'	=> 'vouchers'
							  ];	

		if (is_array($params)) {
			$this->buildFromArray($params);
		}
	}

	public function isValid() {
		return ( $this->isValidBooking() && $this->isValidRequest() );
	}

	/* Verifies the request has the minimum amount of information
	*  to save a booking.  In Rezdy, a booking requires at a minimum,
	*  a customer and at least one item.
	*/
	private function isValidBooking() {
		if ((isset($this->items) && isset($this->customer))) {
			return true;
		} else {
			$this->setError('The booking request does not include the minimum information required to be processed by the API. A valid request must include a customer and at least one item.');
			return false;
		}		
	}
}