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
								    "surcharge"			=> "float",
								    "totalAmount"		=> "float",
								    "totalCurrency"		=> "enum-currency-types",
								    "totalDue"			=> "float",
								    "totalPaid"			=> "float",
								];		

		if (is_array($params)) {
			$this->buildFromArray($params);
		}
	}

	// Adds an item to the booking
	public function addItem($item) {		
		//Verify the Field being added is the correct class 
		if (get_class($item) == 'Rezdy\Requests\BookingItem') {
			$this->items[] = $item;
		}		
	}

	// Sets the Created By Field
	public function setCreatedBy($createdBy) {		
		//Verify the CreatedBy being added is the correct class 
		if (get_class($createdBy) == 'Rezdy\Requests\BookingCreatedBy') {
			$this->createdBy = $createdBy;
		}		
	}

	// Sets the Credit Card Field
	public function setCreditCard($creditCard) {		
		//Verify the Credit Card being added is the correct class 
		if (get_class($creditCard) == 'Rezdy\Requests\BookingCreditCard') {
			$this->creditCard = $creditCard;
		}		
	}

	// Sets the Customer Field
	public function setCustomer($customer) {	
		//Verify the Customer being added is the correct class 
		if (get_class($customer) == 'Rezdy\Requests\BookingCustomer') {
			$this->customer = $customer;
		}		
	}

	// Adds a field to the booking
	public function addField($field) {		
		//Verify the Field being added is the correct class 
		if (get_class($field) == 'Rezdy\Requests\BookingField') {
			$this->fields[] = $fields;
		}		
	}

	// Adds a Payment to the booking
	public function addPayment($payment) {		
		//Verify the Payment being added is the correct class 
		if (get_class($payment) == 'Rezdy\Requests\BookingPayment') {
			$this->payments[] = $payment;
		}		
	}

	// Sets the ResellerUser Field
	public function setResellerUser($reseller) {		
		//Verify the Reseller User being added is the correct class 
		if (get_class($reseller) == 'Rezdy\Requests\BookingResellerUser') {
			$this->resellerUser = $reseller;
		}		
	}

	// Adds a Voucher to the booking
	public function addVoucher($voucher) {		
		//Verify the Voucher being added is the correct class 
		if (get_class($voucher) == 'Rezdy\Requests\BookingVoucher') {
			$this->vouchers[] = $voucher->string;
		}		
	}


	public function __toString() {  
        return json_encode($this);          
    }
}