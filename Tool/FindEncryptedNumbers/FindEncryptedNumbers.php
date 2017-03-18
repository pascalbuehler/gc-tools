<?php
namespace Tool\FindEncryptedNumbers;

class FindEncryptedNumbers extends \Tool\AbstractTool {
    private $result = false;
    
    public function calculate() {
        if(isset($this->data['input']) && strlen($this->data['input'])>0) {
            $this->result = strrev($this->data['input']);
            $this->setSuccess(true);
        }
    }
    
    public function getResult() {
        return $this->result;
    }
    
    public function getOutput() {
        $input = isset($this->data['input']) ?  $this->data['input'] : '';

        $output = '    <div class="row">'.PHP_EOL;
        $output.= '        <div class="col-sm-6">'.PHP_EOL;
        $output.= '            <h3 class="text-primary nomargin-top">Input</h3>'.PHP_EOL;
        $output.= '            <form method="post">'.PHP_EOL;
        $output.= '                <div class="form-group">'.PHP_EOL;
        $output.= '                    <textarea name="input" class="form-control" style="width:100%; height:300px;">'.$input.'</textarea>'.PHP_EOL;
        $output.= '                </div>'.PHP_EOL;
        $output.= '                <div class="form-group">'.PHP_EOL;
        $output.= '                    <button type="submit" class="btn btn-primary">Find</button>'.PHP_EOL;
        $output.= '                </div>'.PHP_EOL;
        $output.= '            </form>'.PHP_EOL;
        $output.= '        </div>'.PHP_EOL;
        if($this->result!==false) {
            $output.= '        <div class="col-sm-6">'.PHP_EOL;
            $output.= '            <h3 class="text-primary nomargin-top">Result</h3>'.PHP_EOL;
            $output.= '            <pre>'.$this->result.'</pre>'.PHP_EOL;
            $output.= '        </div>'.PHP_EOL;
        }
        $output.= '    </div>'.PHP_EOL;
        
        return $output;
    }
}
