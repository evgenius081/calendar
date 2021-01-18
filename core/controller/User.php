<?php


namespace Controller;


class User extends \Controller
{
    public function index()
    {
        $pers = new \Models\User();
        $login = $pers->login();
            if (($login) != false) {
                echo '<div style="color: red; font-size: 24px; font-family: Segoe UI">';
                switch ($login) {
                    case 4:
                    {
                        echo 'Password is wrong';
                        break;
                    }
                    case 1:
                    {
                        echo 'No login entered';
                        break;
                    }
                    case 2:
                    {
                        echo 'No password entered';
                        break;
                    }
                    case 3:
                    {
                        echo 'There is no such a user';
                        break;
                    }
                }
                echo '</div>';
                $this->view('login');
                die();
            }
            header("location: \calendar");
    }

    public function logout(){
        $user = new \Models\User();
        $user->logout();
        header('location: \calendar');
    }

    public function register(){
        $this->view('register');
        $user = new \Models\User();
        $respond = $user->register();
        if($respond != 0) {
            echo '<div style="color: red; font-size: 24px; font-family: Segoe UI">';
            if ($respond === 1) {

            } else if ($respond === 2) {

            }
            switch($respond){
                case 1 :{
                    echo 'No login entered';
                    break;
                }
                case 2 :{
                    echo 'No password entered';
                    break;
                }case 5:{
                echo 'This login is engaged';
                break;
                }
            }

            echo '</div>';
            $this->view('register');
            die();
        }
        $this->index();

//        header('location: \calendar');
    }
}