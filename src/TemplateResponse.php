<?php

namespace WebFw;

/**
 * Implementation of a response object to embed HTML content in the page
 * template and render the result.
 */
class TemplateResponse extends PageResponse {
    public function __construct($template, $params, $page_template=null) {
        $content = Template::render($template, $params);
        
        parent::__construct($content, $page_template);
    }    
}
