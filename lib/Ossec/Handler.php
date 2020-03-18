<?php 

class Handler {
    
    private $dir;
    private $agent_dir;
    private $name;
    private $error;
    
    private $notifyTime = 1200;
    private $dh;
    private static $handler;

    public static function getSingleton() {
        if (!self::$handler instanceof self) {
            self::$handler = new self;
        }
        return self::$instancia;
    }

    function __construct(string $dir) {
        $dh = NULL;
        if(!$handler)
        if($dh = opendir($dir))
        {
            closedir($dh);
            $this->dir = $dir;
            $this->agent_dir = $dir."/queue/agent-info";
        }
        $handler = self;
    }
    /**
     * Verify that the given configuration items are set. Returns
     * NULL on error.
     *
     * 
     * @param string $ossec_dir
     * @param integer $ossec_max_alerts_per_page
     * @param integer $ossec_search_level
     * @param integer $ossec_search_time
     * @param integer $ossec_refresh_time
     * @return boolean
     */
    static public function os_check_config(string $ossec_dir, int $ossec_max_alerts_per_page, 
                            int $ossec_search_level, int $ossec_search_time, 
                            int $ossec_refresh_time) : bool
    {
        $config_err = "<b class='red'>Configuration error. Missing '%s'.</b><br />";

        /* checking each config variable */
        if (!isset($ossec_dir)) {
            echo sprintf($config_err, '$ossec_dir');
            return(0);
        }

        if (!isset($ossec_max_alerts_per_page)) {
            echo sprintf($config_err, '$ossec_max_alerts_per_page');
            return(0);
        }

        if (!isset($ossec_search_level)) {
            echo sprintf($config_err, '$ossec_search_level');
            return(0);
        }

        if (!isset($ossec_search_time)) {
            echo sprintf($config_err, '$ossec_search_time');
            return(0);
        }

        if (!isset($ossec_refresh_time)) {
            echo sprintf($config_err, '$ossec_refresh_time');
            return(0);
        }

        return(1);
    }

}