<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 2017-10-13
 * Time: 1:24 AM
 */

namespace Humber\Validation\Rules;


use Humber\Validation\Rule;

class RequiredRule extends Rule
{
    const RULETYPE = "required";
    private static $ruleInstance;

    public function __construct()
    {
        $this->ruleType = self::RULETYPE;
    }

    /**
     * @return Rule
     */
    static function getInstance()
    {
        if(!isset(self::$ruleInstance)){
            self::$ruleInstance = new RequiredRule();
        }
        return self::$ruleInstance;
    }

    /**
     * @param array $request
     * @param string $field
     * @param array|null $options
     * @return string|null
     */
    function evaluate(array $request, string $field, array $options = null, string $message = null)
    {
       return empty($request[$field]) ? (is_null($message) ? "'$field' no puede estar vacío" : $message) : (is_null($request[$field]) ? (is_null($message) ? "'$field' es obligatorio" : $message) : null);
    }
}