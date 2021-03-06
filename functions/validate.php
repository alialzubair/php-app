<?php

class Validet
{

    private $_passed = false,
        $_errors = array(),
        $_db = null;
    public function __construct()
    {
        $this->_db = DB::getInstace();
    }

    public function check($source, $items = array())
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                @$value = trim($source[$item]);
                if ($rule == 'required' && empty($value)) {
                    $this->addError("{$item} is required");
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value)

                                $this->addError("{$item} must be a minimum of {$rule_value} character");

                            break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("{$item} must be a maximum of {$rule_value} character ");
                            }

                            break;
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} must match {$item}");
                            }

                            break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if (count($check) >0) {
                                $this->addError("{$item} aleady exists");
                            }

                            break;
                    }
                }
            }
        }

        //check the not have errors
        if (empty($this->_errors)) {
            $this->_passed = true;
        }
        return $this;
    }

    //method add error
    public function addError($error)
    {
        $this->_errors[] = $error;
    }

    //method errors

    public function errors()
    {
        return $this->_errors;
    }

    //method passed
    public function passed()
    {
        return $this->_passed;
    }
}
