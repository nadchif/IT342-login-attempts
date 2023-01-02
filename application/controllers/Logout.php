<?php
class Logout extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        if(!$this->session->islogged){
            redirect('Login');
        }
    }

    public function index(){
        $session_array = array('account_name', 'islogged');
        $this->session->unset_userdata($session_array);
        redirect('Login');
    }
}

?>