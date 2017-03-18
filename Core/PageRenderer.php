<?php

namespace Core;

use Helper\ConfigHelper;
use Layout\Layout;

class PageRenderer {
    public static function render($page) {
        if(!$page) {
            throw new \Exception('No page to render');
        }
        
        $config = ConfigHelper::getConfig();

        switch($page) {
            case Router::PAGE_HOME;
                $layout = new Layout('home', ['config' => $config]);
                $layout->render();
                break;
            case Router::PAGE_TOOL;
                $toolName = InputParameters::get('tool');
                $layout = new Layout('tool', ['toolName' => $toolName]);
                ToolRunner::runTool($toolName, $layout, InputParameters::getAll());
                $layout->render();
                break;
            default:
                throw new \Exception('No idea how to render page "'.$page.'"');
        }
    }
}

