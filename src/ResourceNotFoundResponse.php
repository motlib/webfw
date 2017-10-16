<?php

namespace WebFw;

class ResourceNotFoundResponse extends BaseResponse {

    public function __construct($msg='Resource fot found') {
        $this->responseCode = 404;
        $this->contentType = 'text/plain';
        $this->content = $msg;
    }
}
