<?php

namespace App;

use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class Logger extends \Monolog\Logger {

    private $_messages;
    private $_name;

    private $_start_time;

    private $_wait_message;
    private $_wait_start_time;
    private $_use_plog = true;

    public function __construct($dir, $name, $use_plog = true) {
        parent::__construct($name);

        $this->_start_time = microtime(true);
        $this->_name = $name;
        $this->_use_plog = $use_plog;

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
            chmod($dir, 0775);
        }

        $handler = new StreamHandler($dir.'/'.$name.'_'.dt('today', 'Ymd').'.log', \Monolog\Logger::DEBUG, true, 0775);

        $output = "[%datetime%][%level_name%] %message% \n";
        $formatter = new LineFormatter($output);;
        $handler->setFormatter($formatter);

        $this->pushHandler($handler);
    }

    public function setHandler() {
        $err_fn = function ($errno, $message, $file, $line, $alert = false) {
            $filename = pathinfo($file, PATHINFO_BASENAME);

            switch ($errno) {
                case E_ERROR:               $error = 'ERROR';                  break;
                case E_WARNING:             $error = 'WARNING';                break;
                case E_PARSE:               $error = 'PARSE ERROR';            break;
                case E_NOTICE:              $error = 'NOTICE';                 break;
                case E_CORE_ERROR:          $error = 'CORE ERROR';             break;
                case E_CORE_WARNING:        $error = 'CORE WARNING';           break;
                case E_COMPILE_ERROR:       $error = 'COMPILE ERROR';          break;
                case E_COMPILE_WARNING:     $error = 'COMPILE WARNING';        break;
                case E_USER_ERROR:          $error = 'USER ERROR';             break;
                case E_USER_WARNING:        $error = 'USER WARNING';           break;
                case E_USER_NOTICE:         $error = 'USER NOTICE';            break;
                case E_STRICT:              $error = 'STRICT NOTICE';          break;
                case E_RECOVERABLE_ERROR:   $error = 'RECOVERABLE ERROR';      break;
                default:                    $error = 'UNKNOWN ERROR ('.$errno.')'; break;
            }

            $message = '['.$error.' ('.$errno.'): '.$filename.':'.$line.'] '.$message;
            if ($alert) $this->alert($message);
            else $this->error($message);
        };

        set_error_handler($err_fn);

        register_shutdown_function(function() use ($err_fn) {
            $error = error_get_last();
            if ($error && $error['type'] == E_ERROR) {
                $err_fn($error['type'], $error['message'], $error['file'], $error['line'], true);
            }
        });
    }

    public function __destruct() {
        if ($this->_start_time) $this->finish();
    }

    public function finish() {
        $time = round(microtime(true) - $this->_start_time, 4).'s';
        $this->info('FINISHED '.$time);
        $this->info('----------------------');
        $this->_start_time = null;
    }

    private function _plog($message, $new_line = true) {
        if ($this->_use_plog) {
            plog($message, $new_line);
        }
    }

    private function processMessage($message, $type = 'info') {
        if ($this->_wait_message) {
            $time = round(microtime(true) - $this->_wait_start_time, 4).'s';

            if (\Common\Util::isCli()) {
                $cli_message = $message;

                $colors = [
                    'OK' => '32',
                    'ERR' => '31',
                    'FAIL' => '33',
                    'ERROR' => '31'
                ];

                foreach ($colors as $key => $color) {
                    if (in_string($key, $message)) {
                        $cli_message = "\033[{$color}m$cli_message\033[0m";
                        break;
                    }
                }

                $this->_plog("$cli_message \033[36m$time\033[0m");
            } else {
                $this->_plog($message.' '.$time);
            }

            $message = $this->_wait_message.$message.'  '.$time;
            $this->_wait_message = '';
            $this->_wait_start_time = 0;
        } else {
            $cli_message = $message;
            if (\Common\Util::isCli()) {
                $colors = [
                    'emergency' => '31',
                    'error' => '31',
                    'notice' => '95',
                    'alert' => '31',
                    'debug' => '90',
                    'warning' => '93',
                    'critical' => '31'
                ];

                if (isset($colors[$type])) {
                    $color = $colors[$type];
                    $cli_message = "\033[{$color}m$message\033[0m";
                }
            }

            $this->_plog($cli_message);
        }

        $this->_messages[] = $message;

        return $message;
    }

    public function emergency($message, array $context = []): void {
        $message = $this->processMessage($message, 'emergency');
        parent::emergency($message.EOL, $context);
    }

    public function exception($exception, $attachments = null, array $context = []) {
        $message = $this->processMessage($exception, 'alert');
        $mailer = new \Common\Mailer;

        $subject = '['.APP_TITLE.'] '.$this->_name.' Exception';
        $body = \Common\Mailer::formatBody([
            'message' => '
                <p><strong>'.$this->_name.'</strong> process exception: <br><pre><code>'.$exception.'</code></pre></p>
                <p><strong>Log trace:</strong><br />'.implode('<br />', $this->_messages).'</p>',
            'color' => 'danger'
        ]);

        $mailer->submit(APP_ALERTS_EMAIL, $subject, $body, $attachments);
        parent::alert($message.EOL, $context);
    }

    public function alert($message, array $context = []): void {
        $this->exception($message, null, $context);
    }

    public function critical($message, array $context = []): void {
        $message = $this->processMessage($message, 'critical');
        parent::critical($message.EOL, $context);
    }

    public function error($message, array $context = []): void {
        $message = $this->processMessage($message, 'error');
        parent::error($message.EOL, $context);
    }

    public function warning($message, array $context = []): void {
        $message = $this->processMessage($message, 'warning');
        parent::warning($message.EOL, $context);
    }

    public function notice($message, array $context = []): void {
        $message = $this->processMessage($message, 'notice');
        parent::notice($message.EOL, $context);
    }

    public function debug($message, array $context = []): void {
        $message = $this->processMessage($message, 'debug');
        parent::debug($message.EOL, $context);
    }

    public function info($message, array $context = []): void {
        $message = $this->processMessage($message, 'info');
        parent::info($message.EOL, $context);
    }

    public function wait($message) {
        $message = $message.'... ';
        $this->_plog($message, false);

        $time_start = microtime(true);
        if ($this->_wait_start_time > 0) {
            $time_start = $this->_wait_start_time + ($this->_wait_start_time - $time_start);
        }

        $this->_wait_start_time = $time_start;
        $this->_wait_message .= $message;
    }

    public function send($to) {
        $this->_plog($this->_messages);
    }
}