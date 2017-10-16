<?php

namespace WebFw;

class Template {
    /**
     * Execute a PHP template file and return the result as a string.
     *
     * Found here: http://www.bigsmoke.us/pho-templates/functions
     */
    static function render($tpl_file, $vars = array(), $include_globals = true)
    {
        $tmpl_path = ProjectPaths::getFilePath('tmpl', $tpl_file);
        
        extract($vars);
    
        if ($include_globals) {
            extract($GLOBALS, EXTR_SKIP);
        }
    
        ob_start();

        require($tmpl_path);
        $applied_template = ob_get_contents();
        
        ob_end_clean();
    
        return $applied_template;
    }
}