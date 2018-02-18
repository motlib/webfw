<?php

namespace Motlib\WebFW;

/**
 * Interface for response objects that can be handled (sent out) by
 * the Controller class.
 */
abstract class BaseResponse {

    protected $contentType = 'text/plain';
    protected $content = '';
    protected $responseCode = 200;

    /**
     * @returns The content type (mime type) of the
     *   response. E.g. 'text/html' for HTML pages.
     */
    public function getContentType() {
        return $this->contentType;
    }

    
    /**
     * @returns The content that should be sent out to the client. 
     */
    public function getContent() {
        return $this->content;
    }
            


    /**
     * @returns The respose code to send to the client.
     */
    public function getResponseCode() {
        return $this->responseCode;
    }
}
        