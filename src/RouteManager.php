<?php
namespace xenin;

/**
 *
 * A Simple REST API Route Manager for PHP.
 * Create named routes for easy access to REST APIs.
 * RouteManager will assemble and return complete route from pattern supplied.
 * 
 * @author xenin <xenin@xenin.net>
 * @link https://github.com/xenin/RouteManager
 * 
 */

class RouteManager {

    protected $baseUrl = null;
	protected $routes = array();
	
	public function __construct($url = null) {
		if($url !== null) {
            $this->baseUrl = $url;
        }
	}
	
	public function __destruct() {
        $this->opt = null;
    }

    /**
     * Set base url
     *
     * @param string $url       API base url
     */
    public function base($url = null) {
        if($url !== null) {
            $this->baseUrl = $url;
        }
    }
    
    /**
     * Add route
     *
     * @param string $name      Name of route
     * @param string $route     Route pattern eg. /user/{userID}/account
     */
    public function add($name = null, $route = null) {
    	if($name !== null && $route !== null) {
    		$this->routes[$name] = $route;
    	}
    }
    
    /**
     * Get route
     *
     * @param string $name      Name of route
     * @param array $values     Route pattern variables
     *
     * @return string|null      Complete url from pattern
     */
    public function get($name = null, $values = array()) {
        if($this->baseUrl === null) {
            return null;
        }
    	if($name === null || count($values) === 0) {
            return null;
        } else {
    		$all = true;
    		$keys = array_keys($values);
    		$route = $this->routes[$name];
    		$arr = $this->getRouteKeys($route);
    		
    		if(count($values) != count($arr[0])) {
    			return null;
    		}
    		
    		for($i = 0; $i < count($keys); $i++) {
    			$key = '{' . $keys[$i] . '}';
    			$route = str_replace('{' . $keys[$i] . '}', urlencode($values[$keys[$i]]), $route);
    		}
    		
    		$check = $this->getRouteKeys($route);
    		
    		if(count($check[0]) === 0) {
                if (strncmp($route, $this->baseUrl, strlen($this->baseUrl)) !== 0) {
                    $route = rtrim($this->baseUrl, '/') . '/' . ltrim($route, '/');
                }
    			return $route;
    		} else {
    			return null;
    		}
    	}
    }
    
    /**
     * Find pattern keys
     *
     * @param string $route     Route pattern
     *
     * @return array            Match array
     */
    protected function getRouteKeys($route) {
    	preg_match_all("/{[a-zA-Z_]+}/", $route, $ret);
    	return $ret;
    }
}

?>
