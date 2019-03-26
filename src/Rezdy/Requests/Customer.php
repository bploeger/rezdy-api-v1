<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the BookingCustomer request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class Customer extends BaseRequest implements RequestInterface {

	public function __construct($params = '') {
		
		//Set the optional properties of the object and the required type
		$this->optionalParams = [		"aboutUs"			=> "string",
								        "addressLine"		=> "string",
								        "addressLine2"		=> "string",
								        "city"				=> "string",
								        "companyName"		=> "string",
								        "countryCode"		=> "string",
								        "dob"				=> "date-time",
								        "email"				=> "string",
								        "fax"				=> "string",
								        "firstName"			=> "string",
								        "gender"			=> "enum.gender",
								        "id"				=> "integer",
								        "lastName"			=> "string",
								        "marketing"			=> "boolean",
								        "middleName"		=> "string",
								        "mobile"			=> "string",
								        "name"				=> "string",
								        "newsletter"		=> "boolean",
								        "phone"				=> "string",
								        "postCode"			=> "string",
								        "preferredLanguage"	=> "string",
								        "skype"				=> "string",
								        "state"				=> "string",
								        "title"				=> "enum.title"				
								];

		if (is_array($params)) {
			$this->buildFromArray($params);
		}	
	}

	public function isValid() {
		return $this->isValidRequest();
	}
}