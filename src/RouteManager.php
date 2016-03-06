<?php
namespace xenin;

class RouteManager {
	
	protected $opt = array(
		"base" => null,
		"routes" => array()
	);
	
	public function __construct($url = null) {
		if($url !== null) {
            $this->opt["base"] = $url;
        }
	}
	
	public function __destruct() {
        $this->opt = null;
    }

    public function base($url = null) {
        if($url !== null) {
            $this->opt["base"] = $url;
        }
    }
    
    public function add($name = null, $route = null) {
    	if($name !== null && $route !== null) {
    		$this->opt["routes"][$name] = $route;
    	}
    }
    
    public function get($name = null, $values = array()) {
        if($this->opt["base"] === null) {
            return null;
        }
    	if($name === null || count($values) === 0) {
            return null;
        } else {
    		$all = true;
    		$keys = array_keys($values);
    		$route = $this->opt["routes"][$name];
    		$arr = $this->getRouteKeys($route);
    		
    		if(count($values) != count($arr[0])) {
    			return null;
    		}
    		
    		for($i = 0; $i < count($keys); $i++) {
    			$key = '{' . $keys[$i] . '}';
    			$route = str_replace('{' . $keys[$i] . '}', $values[$keys[$i]], $route);
    		}
    		
    		$check = $this->getRouteKeys($route);
    		
    		if(count($check[0]) === 0) {
                if (strncmp($route, $this->opt["base"], strlen($this->opt["base"])) !== 0) {
                    $route = rtrim($this->opt["base"], '/') . '/' . ltrim($route, '/');
                }
    			return $route;
    		} else {
    			return null;
    		}
    	}
    }
    
    protected function getRouteKeys($route) {
    	preg_match_all("/{[a-zA-Z_]+}/", $route, $ret);
    	return $ret;
    }
}

?>