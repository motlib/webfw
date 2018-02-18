<?php

namespace Motlib\WebFW;

require_once('utils.php');

/**
 * Implementation of a response object to send out JSON data.
 */
class JsonResponse extends BaseResponse {
    public function __construct($content) {
        $this->contentType = 'application/json';

        $this->content = json_encode($content, JSON_PRETTY_PRINT);
    }
}