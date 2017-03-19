<?php
namespace Tool\RotXBox;

class RotXBox extends \Tool\AbstractTool {
    private $result = false;
    
    private $operations = [
            '+' => 'addieren',
            '-' => 'subtrahieren',
            '*' => 'multiplizieren',
        ];

    public function calculate() {
        if(!isset($this->data['text']) || !strlen($this->data['text'])>0) {
            return false;
        }
        $operation = isset($this->data['operation']) && in_array($this->data['operation'], array_keys($this->operations)) ? $this->data['operation'] : array_keys($this->operations)[0];
        $colOffsets = isset($this->data['coloffsets']) || !strlen($this->data['coloffsets'])>0 ? explode(' ', $this->data['coloffsets']) : [];
        $lineOffsets = isset($this->data['lineoffsets']) || !strlen($this->data['lineoffsets'])>0 ? explode(' ', $this->data['lineoffsets']) : [];

        $text = $this->data['text'];
        $lineNumber = 0;
        foreach(explode("\n", $text) as $line) {
            $line = trim($line);
            $colNumber = 0;
            foreach(str_split($line) as $character) {
                // Check character
                if(!preg_match('/[A-Za-z0-9]/', $character)) {
                    $colNumber++;
                    continue;
                }
                // Calculate offset
                $offset = 0;
                if(isset($colOffsets[$colNumber]) && is_numeric($colOffsets[$colNumber]) && isset($lineOffsets[$lineNumber]) && is_numeric($lineOffsets[$lineNumber])) {
                    $colOffset = $colOffsets[$colNumber];
                    $lineOffset = $lineOffsets[$lineNumber];
                    switch($operation) {
                        case '+':
                            $offset = $colOffset+$lineOffset;
                            break;
                        case '-':
                            $offset = $colOffset-$lineOffset;
                            break;
                        case '*':
                            $offset = $colOffset*$lineOffset;
                            break;
                    }
                }
                // Do the transformation (if necessary)
                if($offset>0) {
                    $transformedChacter = $this->rotX($character, $offset);
                }
                else {
                    $transformedChacter = $character;
                }
                // Save result
                $this->result.= $transformedChacter;
                $colNumber++;
            }
            $this->result.= PHP_EOL;
            $lineNumber++;
        }

        $this->setSuccess(true);
        return true;
    }
    
    public function getResult() {
        return $this->result;
    }
    
    public function getOutput() {
        $text = isset($this->data['text']) ?  $this->data['text'] : '';
        $coloffsets = isset($this->data['coloffsets']) ?  $this->data['coloffsets'] : '';
        $lineoffsets = isset($this->data['lineoffsets']) ?  $this->data['lineoffsets'] : '';
        $operation = isset($this->data['operation']) ?  $this->data['operation'] : array_keys($this->operations)[0];

        $output = '    <div class="row">'.PHP_EOL;
        $output.= '        <div class="col-sm-6">'.PHP_EOL;
        $output.= '            <h3 class="text-primary nomargin-top">Eingabe</h3>'.PHP_EOL;
        $output.= '            <form method="post">'.PHP_EOL;
        $output.= '                <div class="form-group">'.PHP_EOL;
        $output.= '                    <label>Text</label>'.PHP_EOL;
        $output.= '                    <textarea name="text" class="form-control" style="height:300px;">'.$text.'</textarea>'.PHP_EOL;
        $output.= '                </div>'.PHP_EOL;
        $output.= '                <div class="form-group">'.PHP_EOL;
        $output.= '                    <label>Spaltenoffsets <small>Trennen mit Leerzeichen</small></label>'.PHP_EOL;
        $output.= '                    <input type="text" name="coloffsets" class="form-control" value="'.$coloffsets.'" />'.PHP_EOL;
        $output.= '                </div>'.PHP_EOL;
        $output.= '                <div class="form-group">'.PHP_EOL;
        $output.= '                    <label>Zeilenoffsets <small>Trennen mit Leerzeichen</small></label>'.PHP_EOL;
        $output.= '                    <input type="text" name="lineoffsets" class="form-control" value="'.$lineoffsets.'" />'.PHP_EOL;
        $output.= '                </div>'.PHP_EOL;
        $output.= '                <div class="form-group">'.PHP_EOL;
        $output.= '                    <label>Operation</label>'.PHP_EOL;
        $output.= '                    <select name="operation">'.PHP_EOL;
        foreach($this->operations as $opKey=>$opName) {
            $output.= '                        <option value="'.$opKey.'"'.($operation==$opKey ? 'selected="selected"' : '').'>'.$opName.'</option>'.PHP_EOL;
        }
        $output.= '                    </select>'.PHP_EOL;
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
    
    private function rotX($character, $offset) {
        // Find base character code and character group size
        if(preg_match('/[0-9]/', $character)) {
            $baseCharacterCode = ord('0');
            $characterGroupSize = 10;
        }
        elseif(preg_match('/[a-z]/', $character)) {
            $baseCharacterCode = ord('a');
            $characterGroupSize = 26;
        }
        else {
            $baseCharacterCode = ord('A');
            $characterGroupSize = 26;
        }
        // calculate new cacharcter
        $newCharacterCode = $baseCharacterCode + (ord($character)-$baseCharacterCode+$offset)%$characterGroupSize;
                
        return chr($newCharacterCode);
    }
}