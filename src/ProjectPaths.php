<?php

namespace WebFw;

class ProjectPaths {

    private static $paths = NULL;

    /**
     * Calculate all project paths.
     */
    private static function getPaths() {
        $root = __DIR__ . '/../../';
        
        $paths = [
            'root' => $root,
            'src' => $root . 'src/',
            'res' => $root . 'resources/',
            'tmpl' => $root . 'resources/templates/',
            'cfg' => $root . 'config/',
            'data' => $root . 'data/',
        ];

        /* Convert all relative paths to absolute ones. */
        foreach($paths as $key => $path) {
            $paths[$key] = realpath($path) . '/';
        }

        return $paths;
    }

    static function getFilePath($path_key, $filename) {
        return self::getPath($path_key) . $filename;
    }
    
    
    static function getPath($type) {
        if(self::$paths == NULL) {
            self::$paths = self::getPaths();
        }

        return self::$paths[$type];
    }
}