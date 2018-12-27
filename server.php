<?php
    //gets database configurations
    $settings = json_decode(file_get_contents("configs/database.json"),true);
    $dbcon = $settings["mysql"];

    $dsn      = 'mysql:dbname='.$dbcon["database"].';host='.$dbcon["host"];
    $username = $dbcon["user"];
    $password = $dbcon["password"];
    
    // error reporting (this is a demo, after all!)
    ini_set('display_errors',1);error_reporting(E_ALL);
    
    require_once('src/OAuth2/Autoloader.php');
    OAuth2\Autoloader::register();
    

    $storage = new OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));
    
    // Pass a storage object or array of storage objects to the OAuth2 server class
    $server = new OAuth2\Server($storage);
    
    // Add the "Client Credentials" grant type (it is the simplest of the grant types)
    $server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
    
    // Add the "Authorization Code" grant type (this is where the oauth magic happens)
    $server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));
?>