<?php

namespace WebFw;

/**
 * Implementation of a response object to embed HTML content in the page
 * template and render the result.
 */
class PageResponse extends BaseResponse {
    protected $page_template = 'page.php';

    public function __construct($content, $page_template=null) {
        $this->contentType = 'text/html';
        $this->content = $content;

        if($page_template != null) {
            $this->page_template = $page_template;
        }

        $this->content = Template::render(
            $this->page_template,
            [
                'content' => $this->content
            ]);
    }
}