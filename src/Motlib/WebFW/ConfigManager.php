<?php

namespace Motlib\WebFW;

use \Exception;

/**
 * Exception class for configuration-specific exceptions.
 */
class ConfigException extends Exception {
    
}


/**
 * Manages configuration files.
 */
class ConfigManager {
    /**
     * The actual configuration data.
     */
    protected $cfg = NULL;

    /**
     * Initialize an instance of the Configuration class.
     *
     * @param $cfg_dir The directory where configuration data is located.
     * @param $tag The prefix of the configuration files. E.g. $tag =
     *   'app' leads to searching for app_config.yaml and
     *   app_defaults.yaml.
     */
    public function __construct($cfg_dir, $tag) {
        $this->cfg_dir = $cfg_dir;
        $this->tag = $tag;
    }


    /**
     * Load default configuration and user configuration data and merges them.
     */
    protected function loadConfig() {
        /* Load required defaults file */
        $defaults = $this->loadFromFile(
            $this->tag . "_defaults.yaml",
            true);

        /* Try to load user configuration. */
        $user = $this->loadFromFile(
            $this->tag . "_config.yaml",
            false);

        /* Merge defaults and user config. */
        $this->cfg = array_replace_recursive($defaults, $user);
    }
    
    
    /**
     * @returns The configuration data.
     */
    public function getConfig() {
        if($this->cfg == NULL) {
            $this->loadConfig();
        }

        return $this->cfg;
    }
    

    /**
     * Load configuration data from a YAML file.
     */
    protected function loadFromFile($filename, $required=true) {
        $filepath = $this->cfg_dir . $filename;

        
        if($required && !is_readable($filepath)) {
            throw new ConfigException(
                "Cannot read required configuration file '${filepath}'.");
        }
            
        $data = yaml_parse_file($filepath);
        
        if($data === FALSE) {
            throw new ConfigException(
                "Failed to parse configuration data from '${filepath}'.");
        }

        return $data;
    }
}
    
