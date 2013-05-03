<?php
namespace Except;
use Exception;
use Fig\Fig;
use PDOException;
use Symfony\Component\Yaml\Yaml;

class Except
{
    private static $defaultConfig = array(
        'messages' => array('file' => 'messages.yaml')
    );

    public static function configure($config = array())
    {
        if (!count($config)) {
            $config = self::$defaultConfig;
        }

        Fig::setUp($config);
        echo('......!!!!'.Fig::get('messages.file')."\n\n");
    }

    public static function analyze(Exception $e)
    {
        self::configure();

        $pdoException = self::getPDOException($e);
        if (!$pdoException)
            return;

        if (count($pdoException->errorInfo) == 3)
            $code = $pdoException->errorInfo[1];

        if (empty($code))
            $code = $pdoException->getCode();

        self::parse($code, $pdoException->getMessage());
    }

    private static function parse($code, $errorMessage)
    {
        var_dump(Yaml::parse(file_get_contents(__DIR__ . "/messages.yaml")));
        die();

        list($keys, $pattern, $message) = Message::find($code);
        if (empty($key) && empty($pattern) && empty($message))
            return;

        var_dump([$keys, $pattern, $message]);
        die();

        if (!isset(self::$map[$code])) {
            return;
        }

        $data = [];
        preg_match("/" . Message::$map[$code]['pattern'] . "/i", $errorMessage, $output);
        foreach (Message::$map[$code]['keys'] as $key)
            $data[$key] = $output[$key];

        $i = 0;
    }

    /**
     * @param Exception $e
     * @return PDOException
     */
    private static function getPDOException(Exception $e)
    {
        if ($e instanceof PDOException)
            return $e;

        return self::getPDOException($e->getPrevious());
    }
}