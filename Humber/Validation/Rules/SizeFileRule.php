<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2017-10-11
 * Time: 7:45 PM
 */

namespace Humber\Validation\Rules;

use Humber\Validation\Rule;

class SizeFileRule extends Rule
{
    const RULETYPE = "size_file";
    private static $ruleInstance;

    /**
     * SizeFileRule constructor.
     */
    private function __construct()
    {
        $this->ruleType = self::RULETYPE;
    }

    /**
     * @return SizeFileRule
     */
    public static function getInstance()
    {
        if (!isset(self::$ruleInstance)) {
            self::$ruleInstance = new SizeFileRule();
        }
        return self::$ruleInstance;
    }

    /**
     * @param array $request
     * @param string $field
     * @param array|null $options
     * @param string|null $message
     * @return string|null
     * @throws \Exception
     */
    function evaluate(array $request, string $field, array $options = null, string $message = null)
    {
        if (is_array($options) && is_numeric($options[0])) {
            $maxSize = $options[0] * 1024; // Convertir de KB a bytes
            $fileSize = isset($request[$field]['size']) ? $request[$field]['size'] : 0; // Obtener el tamaño del archivo

            // Comprobar el tamaño del archivo
            if ($fileSize > $maxSize) {
                return is_null($message) ? "'$field' el tamaño máximo permitido es: " . ($options[0] / 1000 . ' MB') : $message;
            }
            return null; // No hay errores
        } else {
            throw new \Exception('Rule \'size\' needs one parameter for the size, usage example (size:5)');
        }
    }


}