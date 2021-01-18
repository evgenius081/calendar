<?php


namespace Models;


class User
{
    const ERROR_UNLOGIN = 1;
    const ERROR_UNPASSWORD = 2;
    const ERROR_NO_USER = 3;
    const ERROR_PASSWORD_FALSE = 4;
    const NO_ERRORS = 0;
    const ENGAGED = 5;
    private $method = 'POST';
    private $inputLogin = 'userlogin';
    private $inputPassword = "password";
    private $db_field_login = 'login';
    private $author = 'anonimus';

    public function __construct(){
//        if(session_status() != PHP_SESSION_ACTIVE){
//            session_start();
//        }
    }

    public function login(){
        $_SERVER["REQUEST_METHOD"] = 'POST';
        if($_SERVER["REQUEST_METHOD"] === 'POST'){
            if(!isset($_POST[$this->inputLogin]) || trim($_POST[$this->inputLogin]) == ''){
                return self::ERROR_UNLOGIN;
            }
            if(!isset($_POST[$this->inputPassword]) || trim($_POST[$this->inputPassword]) == ''){
                return self::ERROR_UNPASSWORD;
            }
        }
        $db=\Model::setInstance();
        $user = $db->table('user')->where($this->db_field_login, '=', $this->inputLogin)->getOne();
        if(!$user){
            return self::ERROR_NO_USER;
        }
        if(!password_verify($_POST[$this->inputPassword], $user['password'])){
            return self::ERROR_PASSWORD_FALSE;
        }
        $_SESSION['token'] = $this->generateToken($user['id']);
        $_SESSION['uid'] = $user['id'];
        $_SESSION['creator'] = $user['login'];
        return self::NO_ERRORS;
    }

    private function generateToken($userID){
        return  md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].$userID);
    }

    public function Auth(){
        return (isset($_SESSION['token'], $_SESSION['uid']) && $_SESSION['token'] === $this->generateToken($_SESSION['uid']));
    }

    public function logout(){
        $_SESSION['token'] = null;
        $_SESSION['uid'] = null;
        session_destroy();
    }

    public function register(){
        if($_SERVER["REQUEST_METHOD"] === 'POST'){
            if(!isset($_POST[$this->inputLogin]) || trim($_POST[$this->inputLogin]) == ''){
                return self::ERROR_UNLOGIN;
            }
            if(!isset($_POST[$this->inputPassword]) || trim($_POST[$this->inputPassword]) == ''){
                return self::ERROR_UNPASSWORD;
            }
        }
        $db=\Model::setInstance();
        $user = $db->table('user')->where($this->db_field_login, '=', $_POST[$this->inputLogin])->getOne();
        if(!$user){
            $user = $db->table('user')->from('(login, password)')->set([$_POST['userlogin'], crypt($_POST['password'])]);
//            $db=\Model::setInstance();
//            $user = $db->table('user')->where($this->db_field_login, '=', $_POST['userlogin'])->getOne();
//            $_SESSION['token'] = $this->generateToken($user['id']);
//            $_SESSION['uid'] = $user['id'];
//            $_SESSION['creator'] = $user['login'];
            return self::NO_ERRORS;
        }else{
            return self::ENGAGED;
        }
    }
}
