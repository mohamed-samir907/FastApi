<?php

namespace FastApi\Console;

use FastApi\Console\Colors\Background;
use FastApi\Console\Colors\Text;

/**
 * Console log messages.
 * 
 * @method void info()
 * @method void warning()
 * @method void success()
 * @method void black()
 * @method void danger()
 * @method void log()
 * @method void requestSuccess()
 * @method void requestFailed()
 * @method string requestLoger()
 */
class Log
{
    /**
     * Console log info message.
     *
     * @param  mixed $value
     * @param  bool $isBackground
     * @param  string $msg
     * @return void
     */
    public static function requestSuccess(array $requestServer, $msg = '200 OK')
    {
        $line = self::requestLoger($requestServer);
        $line .= Text::GREEN . $msg;
        
        return self::printThenClear($line);
    }

    /**
     * Console log info message.
     *
     * @param  mixed $value
     * @param  bool $isBackground
     * @param  string $msg
     * @return void
     */
    public static function requestError(array $requestServer, $msg)
    {
        $line = self::requestLoger($requestServer);
        $line .= Text::LIGHT_RED . $msg;
        
        return self::printThenClear($line);
    }

    /**
     * Get the request info to log it.
     *
     * @param  array $requestServer
     * @return string
     */
    public static function requestLoger(array $requestServer)
    {
        $method = $requestServer['request_method'];
        $uri = $requestServer['request_uri'];
        $protocol = $requestServer['server_protocol'];

        $line = Text::GREEN . "INFO:\t" . Text::DEFAULT;
        $line .= "\"" . self::getRequestMethodColor($method) . " $uri\" ";;

        return $line;
    }

    /**
     * Get the request method color.
     *
     * @param  string $method
     * @return string
     */
    private static function getRequestMethodColor($method)
    {
        $text = "\e[1m$method\e[0m";

        switch ($method) {
            case 'GET':
                return Text::GREEN . $text;
            case 'POST':
                return Text::YELLOW . $text;
            case 'PUT':
                return Text::BLUE . $text;
            case 'DELETE':
                return Text::RED . $text;
            default:
                return Text::DARK_GRAY . $text;
        }
    }

    /**
     * Console log info message.
     *
     * @param  mixed $value
     * @param  bool $isBackground
     * @return void
     */
    public static function info($value, bool $isBackground = false)
    {
        if ($isBackground) {
            return self::printThenClear(Background::BLUE . Text::WHITE . $value);
        }

        return self::printThenClear(Text::BLUE . $value);
    }

    /**
     * Console log warning message.
     *
     * @param  mixed $value
     * @param  bool $isBackground
     * @return void
     */
    public static function warning($value, bool $isBackground = false)
    {
        if ($isBackground) {
            return self::printThenClear(Background::YELLOW . Text::WHITE . $value);
        }

        return self::printThenClear(Text::YELLOW . $value);
    }

    /**
     * Console log success message.
     *
     * @param  mixed $value
     * @param  bool $isBackground
     * @return void
     */
    public static function success($value, bool $isBackground = false)
    {
        if ($isBackground) {
            return self::printThenClear(Background::GREEN . Text::WHITE . $value);
        }

        return self::printThenClear(Text::GREEN . $value);
    }

    /**
     * Console log black message.
     *
     * @param  mixed $value
     * @param  bool $isBackground
     * @return void
     */
    public static function black($value, bool $isBackground = false)
    {
        if ($isBackground) {
            return self::printThenClear(Background::BLACK . Text::WHITE . $value);
        }

        return self::printThenClear(Text::BLACK . $value);
    }

    /**
     * Console log danger message.
     *
     * @param  mixed $value
     * @param  bool $isBackground
     * @return void
     */
    public static function danger($value, bool $isBackground = false)
    {
        if ($isBackground) {
            return self::printThenClear(Background::LIGHT_RED . Text::WHITE . $value);
        }

        return self::printThenClear(Text::LIGHT_RED . $value);
    }

    /**
     * Console log default message.
     *
     * @param  mixed $value
     * @return void
     */
    public static function log($value)
    {
        return self::printThenClear($value);
    }

    /**
     * Reset the end of line color to be default colors.
     *
     * @return void
     */
    public static function clear()
    {
        echo Background::DEFAULT . Text::DEFAULT . "\n";
    }

    /**
     * Print the given value then reset the line.
     *
     * @param  mixed $value
     * @return void
     */
    public static function printThenClear($value)
    {
        echo $value;

        self::clear();
    }
}