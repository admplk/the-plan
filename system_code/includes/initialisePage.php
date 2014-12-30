<?php
session_start();

//Include the database configuration
require_once('dbLogin.php');

$footerPage = 0;
$pageId = 0;

/*
 * Define the auto-load function for classes
 */
function __autoload($class){    
//function autoloadOriginal($class){    
    $classPath = explode('_', $class);
//    print_r($classPath);
    if ($classPath[0] != 'Google') 
    {              
        if (preg_match('/\\\\/', $class)){
            $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        }

        $filename = "components". DIRECTORY_SEPARATOR . $class . ".php";

        if (fileExists($filename)){
//            print_r("loading file " . $filename . "<br />");
            require_once $filename;
        }else if (fileExists($class.".php")){
//            print_r("loading class " . $class . "<br />");
            require_once $class.".php";
        }
    }
    else
    {
        GoogleIntegrationAutoLoad($classPath);
    }
}

function GoogleIntegrationAutoLoad($classPath)
{
    if (count($classPath) > 3) 
    {
        // Maximum class file path depth in this project is 3.
        $classPath = array_slice($classPath, 0, 3);
    }
    
    $filePath = 'google-api-php-client'. DIRECTORY_SEPARATOR. 'src'. DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $classPath) . '.php';        
    if (fileExists($filePath)) {
//        print_r("loading google file " . $filePath . "<br />");
        require_once($filePath);
    }
//    else
//    {
//        print_r("google file not found");
//    }
}

/*
 * Checks whether a certain file exists.
 */
function fileExists($file)
{       
    $ps = explode(PATH_SEPARATOR, ini_get('include_path'));
    foreach($ps as $path)
    {    
        if(file_exists($path.DIRECTORY_SEPARATOR.$file)) return true;
    }
    
    if(file_exists($file)) return true;
    return false;
}
?>