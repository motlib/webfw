<?php

namespace WebFw\Utils;
        
class CssColors {
    /* Color map going from green over orange to red. */
    protected static $red_green_map = array(
        array(0, 200, 0), // green
        array(255,220, 0), // orange
        array(255, 0, 0)); // red

    
    /**
     * Map $val between 0 and 1 to a color, e.g. to be used for a color
     * scale indicating system load or temperature.
     *
     * By default a green - orange - red map is used, but other maps can
     * be supplied in the $map parameter as an array of RGB vectors.
     *
     * @param $val The value between 0 and 1 to map to a color.
     *
     * @param $map The color map to use. If null, a default green - orange - red
     *   map is used. Specify an array of multiple (at least two) rgb color
     *   vectors.
     *
     * @returns An array with red, green, blue components.
     */
    protected static function getColorMapping($val, $map=NULL) {
        /* Limit input to range [0, 1]. */
        $val = max(0.0, min(1.0, $val));
        
        /* Get the default map, if no other map is given. */
        if($map == NULL) {
            $map = self::$red_green_map;
        }
        
        /* Number of intervals in map. */
        $n = count($map) - 1;

        /* Calculate index of the lower relevant color vector. Prevent
         * edge case if $val == 1.0 by limiting $pi index.*/
        $col_idx = min(floor($val * $n), $n - 1);
        
        /* Get the start and and end color vectors. */
        $col_s = $map[$col_idx];
        $col_e = $map[$col_idx + 1];
        
        /* Calculate length of one interval. */
        $intlen = 1.0 / $n;
        
        /* Start value of curent interval. */
        $ints = $intlen * $col_idx;
        
        /* Map $val to [0..1] range in interval again. */
        $val -= $ints;
        $val /= $intlen;
        
        /* Linear interpolate between interval start and end vectors. */
        $col = array(
            'r' => $col_s[0] + ($val * ($col_e[0] - $col_s[0])),
            'g' => $col_s[1] + ($val * ($col_e[1] - $col_s[1])),
            'b' => $col_s[2] + ($val * ($col_e[2] - $col_s[2])),
        );

        return $col;
    }

    
    /**
     * Convert percentage to color (green to red).
     *
     * Implements trivial mapping between red and green (and a brownish orange
     * inbetween).
     */
    protected static function getPercentRgb($p)
    {
        return array(
            'r' => intval((255 * $p)),
            'g' => intval((255 * (100 - $p))),
            'b' => intval(0),
        );
    }

    
    /**
     * Convert value between 0 and 1 to an CSS color expression like
     * 'rgb(0.1, 0.7, 0.25)'.
     *
     * @param $p Value to convert to color.
     *
     * @returns A CSS color spec like 'rgb(0.1, 0.7, 0.25)'.
     */
    public static function getCssPercentRgb($p)
    {
        /* $c = self::getPercentRgb($p / 100.0); */

        $c = self::getColorMapping($p / 100.0);
        
        return sprintf("rgb({$c['r']},{$c['g']},{$c['b']})");
    }
}

    