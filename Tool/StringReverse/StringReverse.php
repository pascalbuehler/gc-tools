<?php
namespace Tool\StringReverse;

class StringReverse extends \Tool\AbstractTool {
    private $result = false;
    
    public function calculate() {
        if(!isset($this->data['text']) || !strlen($this->data['text'])>0) {
            return false;
        }

        $text = $this->data['text'];
        foreach(explode("\n", $text) as $line) {
            $line = trim($line);
            $this->result.= strrev($line).PHP_EOL;
        }

        $this->setSuccess(true);
        return true;
    }
    
    public function getResult() {
        return $this->result;
    }
    
    public function getOutput() {
        $text = isset($this->data['text']) ?  $this->data['text'] : '';

        $output = '    <div class="row">'.PHP_EOL;
        $output.= '        <div class="col-sm-6">'.PHP_EOL;
        $output.= '            <h3 class="text-primary nomargin-top">Eingabe</h3>'.PHP_EOL;
        $output.= '            <form method="post">'.PHP_EOL;
        $output.= '                <div class="form-group">'.PHP_EOL;
        $output.= '                    <label>Text</label>'.PHP_EOL;
        $output.= '                    <textarea name="text" class="form-control" style="height:300px;">'.$text.'</textarea>'.PHP_EOL;
        $output.= '                </div>'.PHP_EOL;
        $output.= '                <div class="form-group">'.PHP_EOL;
        $output.= '                    <button type="submit" class="btn btn-primary">run</button>'.PHP_EOL;
        $output.= '                </div>'.PHP_EOL;
        $output.= '            </form>'.PHP_EOL;
        $output.= '        </div>'.PHP_EOL;
        if($this->result!==false) {
            $output.= '        <div class="col-sm-6">'.PHP_EOL;
            $output.= '            <h3 class="text-primary nomargin-top">Resultat</h3>'.PHP_EOL;
            $output.= '            <pre>'.$this->result.'</pre>'.PHP_EOL;
            $output.= '        </div>'.PHP_EOL;
        }
        $output.= '    </div>'.PHP_EOL;
        
        return $output;
    }
}
