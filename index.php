<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);

class MyDB extends SQLite3 {
    function __construct() {
       $this->open('friends.db');
    }
 }

 $db = new MyDB();
 if(!$db) {
    echo $db->lastErrorMsg();
    exit();
 } 
 
$app = new \Slim\App;
$app->get(
    '/friends/{id}',
    function (Request $request, Response $response, array $args) use ($db) {
    	$id = $args['id'];
    	
        $sql = "select * from participant where id =$id";
        $ret = $db->query($sql);
        $friends = [];
        while ($friend = $ret->fetchArray(SQLITE3_ASSOC)) {
            $friends[] = $friend;
        }
        return $response->withJson($friends);
    }
);
$app->run();





