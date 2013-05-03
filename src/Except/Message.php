<?php
namespace Except;
class Message
{
    const UNKNOWN_DATABASE = 1049;
    const DUPLICATE_ENTRY = 1062;

    private static $map = array(
        self::UNKNOWN_DATABASE => array(
            'keys' => ['database'],
            'pattern' => "Unknown database \'(?'database'\w+)\'",
            'message' => "Unknown database ':database'"
        ),
        self::DUPLICATE_ENTRY => array(
            'keys' => ['email'],
            'pattern' => "Duplicate entry \'(?'email'[^\']+?)\' for key \'(?'key'[^\']+?)\'",
            'message' => "Duplicate entry ':email' for key"
        ),
    );

    /**
     * @param $code
     * @return array|null
     */
    public static function find($code)
    {
        if(!isset(self::$map[$code]))
            return null;

        return array_values(self::$map[$code]);
    }
}