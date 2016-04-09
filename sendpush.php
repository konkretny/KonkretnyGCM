<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
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
        
        //SET API key
        $token->setApi_server_key('asdasds');
        
        //GET Token array
        $token->pdo_read();
        $token_array = $token->getToken_array();
        $token->setMesseage(array('message'=>'Example push by KonkretnyGCM'));
        $token->sendPush($token_array,$token->getMesseage());

        ?>
    </body>
</html>
