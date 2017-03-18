<?php

namespace Core;

use Core\InputParameters;
use Helper\ConfigHelper;

class Router {
    const PAGE_HOME = 'home';
    const PAGE_TOOL = 'tool';
    
    public static function route($url) {
        $url = mb_substr($url, -1, 1)=='/' ? mb_substr($url, 0, -1) : $url;
        $urlpieces = strlen($url)>0 ? explode('/', $url) : [];

        // Home
        if(!is_array($urlpieces) || count($urlpieces)<1) {
            InputParameters::set('page', self::PAGE_HOME);
            return true;
        }
        
        // Tool
        if(count($urlpieces)==1 && isset($urlpieces[0])) {
            $config = ConfigHelper::getConfig();
            foreach($config['tools'] as $name=>$toolConfig) {
                if($toolConfig['route']==$urlpieces[0]) {
                    InputParameters::set('page', self::PAGE_TOOL);
                    InputParameters::set('tool', $name);
                    break;
                }
            }
            return true;
        }
   
        return false;
    }
}
