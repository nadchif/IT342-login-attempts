<?php
class Home extends CI_Controller {
   public function __construct()
   {
        parent::__construct();
        if(!$this->session->islogged){
            redirect('login');
        }else if($this->session->user_lvl==2){
            redirect('home');
        }
   }

   public function index(){
        $data["title"] = "Adminstration Panel";
        $this->load->view('admin/home', $data);
    }
}
?>