<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2017-10-11
 * Time: 2:31 PM
 */

namespace Humber\Validation\Rules;

use Humber\Validation\Rule;

class FilledRule extends Rule
{
    const RULETYPE = "filled";
    private static $ruleInstance;

    /**
     * FilledRule constructor.
     */
    private function __construct()
    {
        $this->ruleType = self::RULETYPE;
    }

    /**
     * @return FilledRule
     */
    public static function getInstance()
    {
        if (!isset(self::$ruleInstance)) {
            self::$ruleInstance = new FilledRule();
        }
        return self::$ruleInstance;
    }

    /**
     * @param array $request
     * @param string $field
     * @param array|null $options
     * @param string|null $message
     * @return string|null
     */
    function evaluate(array $request, string $field, array $options = null, string $message = null)
    {
        return empty($request[$field]) ? (is_null($message) ? "'$field' no puede estar vacío" : $message) : null;
    }
}