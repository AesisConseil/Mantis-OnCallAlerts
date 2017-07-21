<?php

/** Méthode permettant de logger des données
 */
final class Logger {

    const TRACE     = 10;
    const DEBUG     = 20;
    const INFO      = 30;
    const WARN      = 40;
    const ERROR     = 50;
    const FATAL     = 60;

    private static $fileCrit = self::TRACE;
    private static $outputCrit = 70;

    private static $_logFolder;
    /** Méthode permettant de récupérer le chemin vers le dossier des logs
     *  @return {string} Le chemin vers le dossier des logs
     */
    public static function getLogFolder () {
        if (empty(self::$_logFolder)) {
            $logFolder = getenv('LOG_FOLDER');
            $logFolder = empty($logFolder) ? (__DIR__ . '../../logs') : $logFolder;
            if (!is_dir($logFolder)) {
                @mkdir($logFolder, 0777, true);
            }
            self::$_logFolder = $logFolder;
        }
        return self::$_logFolder;
    }


    /** Méthode permettant d'écrire le log
     *  @param {array} $data - Les données du log
     */
    private static function _write ($data) {
        if (self::$fileCrit <= $data['level']) {
            file_put_contents(self::getLogFolder() . '/logOnCallAlerts_' . date("Y_m_d") . '.log', json_encode($data) . PHP_EOL, FILE_APPEND);
        }
        if (self::$outputCrit <= $data['level']) {
            echo $data['msg'] . PHP_EOL;
        }
    }



    /** Méthode permettant de logger des données
     *  @param {int} $crit - La criticité du log
     *  @param {any} $message - Le contenu du log
     *  @param {?string} $path - Le chemin vers le fichier de log (Si fichier spécifique)
     */
    public static function log ($crit, $message, $path=null) {
        $data = [];
        $data['level'] = $crit;

        $time = new DateTime();
        $data['time'] = $time->format('c');
        $data['msg'] = is_string($message) ? $message : json_encode($message);

        // Bunyan compliant
        $data['name'] = 'Aesis Sms log';
        $data['hostname'] = gethostname();
        $data['pid'] = getmypid();
        $data['v'] = 0;

/*
        // Add debug data
        $data['trace'] = join(' ; ', array_map(
            function ($trace) {
                return str_replace(realpath(__DIR__ . '/../..'), '', $trace['file']) . ':' . $trace['line'];
            },
            array_slice(debug_backtrace(), 1)
        ));
*/

        if (is_null($path)) {
            self::_write($data);
        }
        else {
            file_put_contents($path, json_encode($data) . PHP_EOL, FILE_APPEND);
        }
    }


    /** Méthode permettant de logger des données de criticité TRACE
     *  @param {any} $message - Le contenu du log
     */
    public static function trace   ($message) { self::log(self::TRACE,  $message); }


    /** Méthode permettant de logger des données de criticité DEBUG
     *  @param {any} $message - Le contenu du log
     */
    public static function debug   ($message) { self::log(self::DEBUG,  $message); }


    /** Méthode permettant de logger des données de criticité INFO
     *  @param {any} $message - Le contenu du log
     */
    public static function info    ($message) { self::log(self::INFO,   $message); }


    /** Méthode permettant de logger des données de criticité WARN
     *  @param {any} $message - Le contenu du log
     */
    public static function warn    ($message) { self::log(self::WARN,   $message); }


    /** Méthode permettant de logger des données de criticité ERROR
     *  @param {any} $message - Le contenu du log
     */
    public static function error   ($message) { self::log(self::ERROR,  $message); }


    /** Méthode permettant de logger des données de criticité FATAL
     *  @param {any} $message - Le contenu du log
     */
    public static function fatal   ($message) { self::log(self::FATAL,  $message); }

}