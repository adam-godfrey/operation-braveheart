<?php

class Bootstrap {

    private $_url = null;
    private $_controller = null;
    
    private $_controllerPath = 'controllers/'; // Always include trailing slash
    private $_modelPath = 'models/'; // Always include trailing slash
    private $_errorFile = 'error.php';
    private $_defaultFile = 'index.php';
	
	private $_adminController = null;
    
    private $_adminControllerPath = 'controllers/admin/'; // Always include trailing slash
    private $_adminModelPath = 'models/admin/'; // Always include trailing slash
    private $_adminErrorFile = 'error.php';
    private $_defaultAdminFile = 'index.php';
    
    /**
     * Starts the Bootstrap
     * 
     * @return boolean
     */
    public function init()
    {
        // Sets the protected $_url
        $this->_getUrl();
		
		$this->_url = str_replace('-', '_', $this->_url);

        // Load the default controller if no URL is set
        // eg: Visit http://localhost it loads Default Controller
        if (empty($this->_url[0])) {
            $this->_loadDefaultController();
			$this->_controller->loadModel($this->_url[0], $this->_modelPath);
            return false;
        }
		elseif ($this->_url[0] == 'admin') {
			if (empty($this->_url[1])) {
				$this->_loadDefaultAdminController();
				$this->_adminController->loadModel($this->_url[0], $this->_adminModelPath);
				return false;
			}
			$this->_loadExistingAdminController();
			$this->_callAdminControllerMethod();
            return false;
        }
		
        $this->_loadExistingController();
        $this->_callControllerMethod();
    }
    
    /**
     * Fetches the $_GET from 'url'
     */
    private function _getUrl()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->_url = explode('/', $url);
    }
    
    /**
     * This loads if there is no GET parameter passed
     */
    private function _loadDefaultController()
    {
        require $this->_controllerPath . $this->_defaultFile;
		
        $this->_controller = new Index();
		$this->_controller->loadModel('index', $this->_modelPath);
        $this->_controller->index();
    }
    
    /**
     * Load an existing controller if there IS a GET parameter passed
     * 
     * @return boolean|string
     */
    private function _loadExistingController()
    {
        $file = $this->_controllerPath . $this->_url[0] . '.php';
        
        if (file_exists($file)) {
            require $file;
            $this->_controller = new $this->_url[0];
            $this->_controller->loadModel($this->_url[0], $this->_modelPath);
        } else {
            $this->_error();
            return false;
        }
    }
    
    /**
     * If a method is passed in the GET url paremter
     * 
     *  http://localhost/controller/method/(param)/(param)/(param)
     *  url[0] = Controller
     *  url[1] = Method
     *  url[2] = Param
     *  url[3] = Param
     *  url[4] = Param
     */
    private function _callControllerMethod()
    {
        $length = count($this->_url);
        
        // Make sure the method we are calling exists
        if ($length > 1) {
            if (!method_exists($this->_controller, $this->_url[1])) {
                $this->_error();
            }
        }
        
        // Determine what to load
        switch ($length) {
            case 5:
                //Controller->Method(Param1, Param2, Param3)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4]);
                break;
            
            case 4:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3]);
                break;
            
            case 3:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}($this->_url[2]);
                break;
            
            case 2:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}();
                break;
            
            default:
                $this->_controller->index();
                break;
        }
    }
    
    /**
     * Display an error page if nothing exists
     * 
     * @return boolean
     */
    private function _error() {
        require $this->_controllerPath . $this->_errorFile;
        $this->_controller = new Error();
        $this->_controller->index();
        exit;
    }
	
	/**
     * This loads if there is no GET parameter passed
     */
    private function _loadDefaultAdminController()
    {
        require $this->_adminControllerPath . $this->_defaultAdminFile;
		
        $this->_adminController = new Index();
		$this->_adminController->loadModel('index', $this->_adminModelPath);
        $this->_adminController->index();
    }
    
    /**
     * Load an existing controller if there IS a GET parameter passed
     * 
     * @return boolean|string
     */
    private function _loadExistingAdminController()
    {
        $file = $this->_adminControllerPath . $this->_url[1] . '.php';
        
        if (file_exists($file)) {
            require $file;
            $this->_adminController = new $this->_url[1]();
            $this->_adminController->loadModel($this->_url[1], $this->_adminModelPath);
        } else {
            $this->_adminError();
            return false;
        }
    }
    
    /**
     * If a method is passed in the GET url paremter
     * 
     *  http://localhost/controller/method/(param)/(param)/(param)
     *  url[0] = Controller
     *  url[1] = Method
     *  url[2] = Param
     *  url[3] = Param
     *  url[4] = Param
     */
    private function _callAdminControllerMethod()
    {
        $length = count($this->_url);

        // Make sure the method we are calling exists
        if ($length > 2) {
            if (!method_exists($this->_adminController, $this->_url[2])) {
                $this->_error();
            }
        }
        
        // Determine what to load
        switch ($length) {
            case 6:
                //Controller->Method(Param1, Param2, Param3)
                $this->_adminController->{$this->_url[2]}($this->_url[3], $this->_url[4], $this->_url[5]);
                break;
            
            case 5:
                //Controller->Method(Param1, Param2)
                $this->_adminController->{$this->_url[2]}($this->_url[3], $this->_url[4]);
                break;
            
            case 4:
                //Controller->Method(Param1, Param2)
                $this->_adminController->{$this->_url[2]}($this->_url[3]);
                break;
            
            case 3:
                //Controller->Method(Param1, Param2)
                $this->_adminController->{$this->_url[2]}();
                break;
            
            default:
                $this->_adminController->index();
                break;
        }
    }
    
    /**
     * Display an error page if nothing exists
     * 
     * @return boolean
     */
    private function _adminError() {
        require $this->_adminControllerPath . $this->_adminErrorFile;
        $this->_adminController = new Error();
        $this->_adminController->index();
        exit;
    }

}