<?php

namespace Motlib\WebFW;

use \Exception;
use \Error;

class ControllerException extends Exception { }


/**
 * The controller is the main class that handles client requests and
 * generates the output to send back to the client.
 * 
 * It parses the request parameters in the 'route' function and then
 * calls the appropriate action handler function to calculate the
 * result to send back to the client.
 */
class Controller {

    protected $action_classes = array();
    
    /**
     * Route the request according to the parameters. This determines the
     * action function to be called.
     */
    private function route($context) {
        $action = 'index';
    
        if($context->hasParam('action')) {
            $action = $context->getParam('action');
        } else {
            $action = 'index';
        }
    
        return $action;
    }

    public function addActionClass($class_name) {
        $this->action_classes[] = $class_name;
    }
    
    /**
     * Generate the content based on the determined route by calling the
     * action function.
     */
    public function dispatch() {
        $context = new Context();
        
        try {
            $action = $this->route($context);
            
            $fname = 'dispatch_' . $action;

            $handled = false;
            foreach($this->action_classes as $action_class) {
                if(method_exists($action_class, $fname)) {
                    $inst = new $action_class();
                    $response = $inst->$fname($context);
                    $handled = true;
                    break;
                }
            }

            if($handled == false) {
                throw new ControllerException(
                    "Failed to locate action handler for action '${action}'. ");
            }

            if($response == null) {
                throw new ControllerException(
                    "Action handler function '${action_class}.${fname}' "
                    . "returned NULL response.");
            }

            if(! is_subclass_of($response, 'WebFw\BaseResponse')) {
                throw new ControllerException(
                    "Action handler function '${action_class}.${fname}' "
                    . "did not return an 'WebFw\BaseResponse' instance.");
            }
            
        } catch(Exception $e) {
            $content = Template::render('error.php', array('ex' => $e));
            $response = new PageResponse($content);
        } catch(Error $e) {
            $content = Template::render('error.php', array('ex' => $e));
            $response = new PageResponse($content);
        }

        http_response_code($response->getResponseCode());
        header('Content-Type: ' . $response->getContentType());
        echo $response->getContent();
    }
}