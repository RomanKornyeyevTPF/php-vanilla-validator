<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 2017-10-13
 * Time: 1:04 AM
 */

namespace Humber\Validation\Rules;


use Humber\Validation\Rule;

class DateRule extends Rule
{
    const RULETYPE = "date";
    private static $ruleInstance;

    /**
     * DateRule constructor.
     */
    public function __construct()
    {
        $this->ruleType = self::RULETYPE;
    }

    /**
     * @return Rule
     */
    static function getInstance()
    {
        if (!isset(self::$ruleInstance)) {
            self::$ruleInstance = new DateRule();
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
        return !strtotime($request[$field]) ? (is_null($message) ? "'$field' no es una fecha válida" : $message) : null;
    }
}