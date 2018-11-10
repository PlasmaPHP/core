<?php
/**
 * Plasma Core component
 * Copyright 2018 PlasmaPHP, All Rights Reserved
 *
 * Website: https://github.com/PlasmaPHP
 * License: https://github.com/PlasmaPHP/core/blob/master/LICENSE
*/

namespace Plasma;

/**
 * Common utilities for components.
 */
class Utility {
    /**
     * Parses a query containing parameters into an array, and can replace them with a predefined replacement (can be a callable).
     * The callable is used to return numbered parameters (such as used in PostgreSQL), or any other kind of parameters supported by the DBMS.
     * @param string                $query
     * @param string|callable|null  $replaceParams  If `null` is passed, it will not replace the parameters.
     * @return array  `[ 'query' => string, 'parameters' => array ]`  The `parameters` array is an numeric array (= position), which mappes to the parameter.
     */
    static function parseParameters(string $query, $replaceParams = '?', string $regex = '/(:[a-z]+)|\?|\$\d+/i'): array {
        $params = array();
        
        $position = 1;
        \preg_match_all($regex, $query, $matches);
        
        foreach($matches[0] as $match) {
            if($replaceParams !== null) {
                $replacement = (\is_callable($replaceParams) ? $replaceParams() : $replaceParams);
                $query = \preg_replace('/'.preg_quote($match, '/').'/', $replacement, $query, 1);
            }
            
            $params[($position++)] = $match;
        }
        
        return array('query' => $query, 'parameters' => $params);
    }
}
