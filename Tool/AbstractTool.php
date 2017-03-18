<?php
namespace Tool;

abstract class AbstractTool implements ToolInterface {
    protected $data = null;
    protected $parameters = [];
   
    private $success = false;
    
    public function __construct(array $data, array $parameters = []) {
        $this->data = $data;
        $this->parameters = $parameters;
    }

    public function getOutput() {
        return '';
    }

    public function setSuccess($success) {
        $this->success = $success;
    }
    
    public function getSuccess() {
        return $this->success;
    }
}
