<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        /*
        Author: Marcin Romanowicz
        URL: http://konkretny.pl/
        License: MIT
        Version: 1.0
        */
        
        require_once('KonkretnyGCM.class.php');
        $token = new KonkretnyGCM();
        
        //database connection settings
        $token->setDatabase_type(0); //0 - MySQL or MariaDB, 1- PostreSQL
        /*
        $token->setPqsqlschema('your schema') //schema PostreSQL - OPTIONAL
         */
        $token->setHost('localhost'); //database host
        $token->setDb_name('database_name'); //database name
        /*
        $token->setPort(1234567); //if your port other than the default for a given database - OPTIONAL
        */
        $token->setDb_user('database_username'); //database user name
        $token->setDb_password('database_password'); //database password
        $token->setTablename('database_tablename'); //your table in database with tokens
        $token->setColumnname_tokens('database_columnname'); //your column in database with tokens
        
        
        
        //GET Token
        if(isset($_GET['token']) && strlen($_GET['token'])>100){
            $token->setToken($_GET['token']);
        }
        else{
            echo 'The token is not valid';
            exit;
        }
        
        //execute
        
        $token->pdo_insert(); //enable connection with database and add token to database
    
        ?>
    </body>
</html>
