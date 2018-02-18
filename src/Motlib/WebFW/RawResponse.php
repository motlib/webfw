<?php

namespace Motlib\WebFW;


/**
 * Implementation of a response object to send out JSON data.
 */
class RawResponse extends BaseResponse {
    public function __construct($type, $content) {
        $this->contentType = $type;
        $this->content = $content;
    }
}