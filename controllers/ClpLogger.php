<?php

class Clp_Logger
{
    public function log($message)
    {
        $logfile = plugin_dir_path( __FILE__ ) . '../logger.log';
        error_log("[".date('Y-m-d h:s:i')."]". $message."\n", 3, $logfile);
    }
}
