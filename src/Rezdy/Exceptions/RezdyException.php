<?php
namespace Rezdy\Exceptions;

use Exception;

/**
 * General exception
 *
 * @package     exceptions
 * @author      Brad Ploeger
 */
class RezdyException extends Exception {
    private $errors;

    private $url;

    public function getErrors() {
        return $this->errors;
    }

    public function setErrors($errors) {

        if (is_array($errors)) {
            $this->errors = $errors;
        } else {
            $this->errors[] = $errors;
        }
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getCurlInfo() {
        return $this->url;
    }
}
