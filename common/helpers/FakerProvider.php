<?php
namespace common\helpers;

class FakerProvider extends \Faker\Provider\Base
{
    public function passportNumber()
    {
        return strtoupper($this->bothify('##-##-######'));
    }
}
