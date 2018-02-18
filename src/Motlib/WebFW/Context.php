<?php

namespace Motlib\WebFW;

use \Exception;

class Context {
    protected $params = NULL;

    protected $config = NULL;

    function __construct() {
        $this->params = $this->loadParams();

        $dir = ProjectPaths::getPath('cfg');
        $tag = 'app';
        $this->config = new ConfigManager($dir, $tag);
    }


    public function getConfig() {
        return $this->config->getConfig();
    }

    
    /**
     * Check if a parameter is available.
     */
    public function hasParam($key) {
        return array_key_exists($key, $this->params);
    }

    
    /**
     * Return the parameter value.
     */
    public function getParam($key) {
        if(!$this->hasParam($key)) {
            throw new Exception("Context parameter '$key' is not available.");
        }

        return $this->params[$key];
    }

    /**
     * Return the array with all parameters.
     */
    public function getParams() {
        return $this->params;
    }
    
    
    /**
     * Load the context parameters.
     */
    protected function loadParams() {
        return array_merge($_GET, $_POST);
    }
}
