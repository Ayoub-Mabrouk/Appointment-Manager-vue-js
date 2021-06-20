<?php
// require $_SERVER['DOCUMENT_ROOT'].'/MVC/app/vendor/autoload.php';
require_once 'vendor/autoload.php';
// require_once 'vendor/firebase/php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


/*
 * Base controller
 * loads the models and views
 */
class Controller
{
    public $data;
    public $key = "randomthing";

    // load model
    public function model($model)
    {
        // require model file
        require_once '../app/models/' . $model . '.php';
        // instantiate model
        return new $model();
    }

    public function authorization($p_id)
    {
        $iat = time();
        $exp = $iat + 60 * 60;
        $payload = array(
            "iss" => "localhost",
            "aud" => "localhost",
            "iat" => $iat,
            'exp' => $exp,
            'p_id' => $p_id
        );
        $jwt = JWT::encode($payload, $this->key, 'HS512');
        return $jwt;
    }
    public function gettoken()
    {
        return isset(apache_request_headers()['authorization']) ? str_replace('Bearer ', '', apache_request_headers()['authorization']) : false;
    }
    public function verifytoken($token)
    {
        if (!!$token) {
            try {
                return isset(JWT::decode($token, $this->key, array('HS512'))->p_id) ? JWT::decode($token, $this->key, array('HS512'))->p_id : false;
            } catch (\Throwable $th) {
                echo json_encode("false");
            }
        }else{
            echo json_encode("false");
        }
    }
    // public function token_finished()
    // {
    //     return $this->verifytoken($this->gettoken()) > 0 ? $this->verifytoken($this->gettoken()) : false;
    // }
}
