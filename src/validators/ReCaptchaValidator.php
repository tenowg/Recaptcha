<?php

use Illuminate\Translation\Translator;

class ReCaptchaValidator extends Illuminate\Validation\Validator {

    public function __construct(Translator $translator, $data, $rules, $messages = array()) {
        $messages = \Lang::get('Recaptcha::validation.recaptcha');

        parent::__construct($translator, $data, $rules, $messages);
    }

    public function validateRecaptcha($attribute, $value, $parameters)
    {
        require_once(__DIR__.'/../recaptchalib.php');
        $privateKey = \Config::get('Recaptcha::privatekey');

        $response = recaptcha_check_answer($privateKey, Request::getClientIp(), $parameters[0], $value);

        if (!$response->is_valid) {
            return false;
        } else {
            return true;
        }
    }
} 