<?php
/**
 * Description of Logger
 *
 * @author laczoka
 */
class Logger {
    const DEBUG_MODE = 'debug_mode';
    const DEBUG_OUT_DIR = 'debug_out_dir';
    
    private $enabled;
    private $directory_output;
    private $logfile;
    private $loghandle;
    private $lastmsgts = 0;
    private $messages = array();

    private static $instance = NULL;

    public function  __construct($dir_out = '/tmp/', $enabled = false) {
        $this->enabled = $enabled;
        $this->directory_output = $dir_out;
        $ts = time();
        $logfilebase = $__SERVER['SERVER_NAME'] ? $__SERVER['SERVER_NAME'] : 'perflog';
        $this->logfile = $this->directory_output.$logfilebase.'.'.$ts.'.log';
        $this->loghandle = fopen($this->logfile, 'w');
    }
    public function logWithTs($message)
    {
        if ($this->enabled) {
            $ts = microtime(true);
            $time_elapsed = $this->lastmsgts ? ($ts - $this->lastmsgts) : 0 ;
            $this->lastmsgts = $ts;

            $this->messages[] = array(
                'text'=> $message,
                'ts' => $time_elapsed
                );
        }
    }

    public function  __destruct() {
        foreach ($this->messages as $msg) {
             fwrite($this->loghandle, $msg['text']."\t\t".((float)$msg['ts']*1000)." msec\n");
        }
        fclose($this->loghandle);
    }

    public static function getLogger() {
        if (NULL == self::$instance) {
            self::$instance = new Logger(
                         $GLOBALS['config'][self::DEBUG_OUT_DIR],
                         $GLOBALS['config'][self::DEBUG_MODE]);
        }
        return self::$instance;
    }

    private function diff_microtime($mt_old,$mt_new)
    {
        list($old_usec, $old_sec) = explode(' ',$mt_old);
        list($new_usec, $new_sec) = explode(' ',$mt_new);
        $old_mt = ((float)$old_usec + (float)$old_sec);
        $new_mt = ((float)$new_usec + (float)$new_sec);
        return $new_mt - $old_mt;
    }

}
?>
