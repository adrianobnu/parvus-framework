<?php
    /**
     * Basic class of Parvus Framework
     */

    namespace Parvus;

    use Illuminate\Events\Dispatcher;
    use Illuminate\Container\Container;
    use Symfony\Component\HttpFoundation\Request;

    class Parvus
    {
        private $environment = 'production';
        private $aApp = array();
        private $request;

        public final function __construct()
        {
            $this->request = \Request::createFromGlobals();

            /** Defines the base URL **/
            $url = (strpos($_SERVER['SERVER_PROTOCOL'], 'HTTPS') !== false ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']);

            define (url,$url.(substr($url,-1) == '/' ? NULL : '/'));

            /** Define the base path **/
            define (path,__DIR__.'/../');

            /** Include the app constant */
            include_once (path.'app/config/Constant.php');

            /** Load the app configuration */
            $this->aApp = include (path.'app/config/App.php');

            /** Init the session */
            session_name(__DIR__);
            session_start();

            $this->environment();
            $this->database();
            $this->controller();
        }

        /**
         * Define the environment
         */
        private final function environment ()
        {
            $aConfig = include(path.'app/config/Environment.php');

            foreach ($aConfig as $environment => $aValue)
            {
                foreach ($aValue as $value)
                {
                    if ($_SERVER['SERVER_NAME'] == $value)
                    {
                        $this->environment = $environment;
                    }
                }
            }

            /** Add a constant */
            define ('environment',$this->environment);
        }

        /**
         * Init the connection with database
         */
        private final function database ()
        {
            $aConfig = include_once (path.'app/config/Database.php');

            /** Load the default driver */
            $driver = $aConfig['driver'];

            /** Load the default configuration */
            $aDefault = $aConfig['default'];

            /** Get the connection config based into the environment and driver */
            $aConnection = $aConfig[$this->environment][$driver];

            /** Add the driver to the connection configuration */
            $aConnection['driver'] = $driver;

            /** Each the connection attributes */
            foreach (array('host','user','password','database','charset','collation') as $field)
            {
                /** If the connection field is null, use the default value */
                if ($aConnection[$field] == NULL && $aDefault[$field] != NULL)
                {
                    $aConnection[$field] = $aDefault[$field];
                }
            }

            /** Connection */
            $database = new \Illuminate\Database\Capsule\Manager();
            $database->addConnection($aConnection);
            $database->setEventDispatcher(new Dispatcher(new Container));
            $database->setAsGlobal();
            $database->bootEloquent();
        }

        /**
         * Init the controller
         */
        private final function controller ()
        {
            /** Get the actual URL, first item is the controller, and the second the method */
            if ($this->request->getPathInfo() != '/')
            {
                $aTmp = explode('/',$this->request->getPathInfo());

                /** Get the method and controller, at the last 2 positions of URL */
                $method     = array_pop($aTmp);
                $controller = array_pop($aTmp);
            }
            else /** If not has controller and method, load the default from config */
            {
                $aConfig = include (path.'app/config/Controller.php');

                $controller = $aConfig['default']['controller'];
                $method     = $aConfig['default']['method'];
            }

            $controller = 'Controller\\'.ucFirst($controller);
            $method 	= 'action'.($_SERVER['REQUEST_METHOD'] == 'POST' ? 'Post' : 'Get').ucfirst($method);

            $has404 = false;

            if (class_exists($controller))
            {
                $class = new $controller();

                if (method_exists($class,$method))
                {
                    $class->$method();
                } else {
                    $has404 = true;
                }
            } else {
                $has404 = true;
            }

            /** If has not found the controller and method */
            if ($has404)
            {
                $view404 = new Parvus\View();

                print($view404->render($this->aApp['error']['404']));
            }
        }
    }

    /** Autoload class */
    spl_autoload_register(function($prName)
    {
        $aDirectory = array('app/controller/','app/model/', 'parvus-framework/lib/');

        /** Load the config from app */
        $aArray = include (path.'app/config/App.php');

        /** Add the libs folders of app */
        foreach ($aArray['folder']['lib'] as $folder)
        {
            array_push($aDirectory,'app/'.$folder);
        }

        foreach ($aDirectory as $directory)
        {
            /** Add / at the directory name */
            if (substr($directory,-1) != '/')
            {
                $directory .= '/';
            }

            $prName = array_pop(explode('/',str_replace('\\','/',$prName)));

            if (file_exists(path.$directory.$prName.'.php'))
            {
                include_once (path.$directory.$prName.'.php');
            }
        }
    });