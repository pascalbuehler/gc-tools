<?php

namespace Core;

use Helper\ConfigHelper;
use Layout\Layout;
use Model\ToolResultModel;
use Tool\ToolInterface;

class ToolRunner {
    
    public static function runTool($name, Layout $layout, array $data) {
        // Check config
        $config = ConfigHelper::getConfig();
        if(!isset($config['tools']) || !is_array($config['tools']) || !in_array($name, array_keys($config['tools']))) {
            throw new \Exception('Tool "'.$tool.'" not availabe');
        }
        if(!isset($config['tools'][$name]['class'])) {
            return false;
        }
        $toolConfig = $config['tools'][$name];

        // Load plugin
        $parameters = isset($toolConfig['parameters']) ? $toolConfig['parameters'] : [];
        $tool = new $toolConfig['class']($data, $parameters);

        // Check plugin
        if(!in_array(ToolInterface::class, class_implements($tool))) {
            return false;
        }
        
        // Create plugin result
        $toolResult = new ToolResultModel();
        $toolResult->name = $name;

        // Run plugin if possbile
        $timeStart = microtime(true);

        $tool->calculate();
        $toolResult->result = $tool->getResult();
        $toolResult->output = $tool->getOutput();
        $toolResult->success = $tool->getSuccess();

        $timeEnd = microtime(true);
        $toolResult->time = $timeEnd - $timeStart;
        
        // Add result to layout
        $layout->addData(['tools', $toolResult->name], $toolResult);
        
        return $toolResult;
    }
}
