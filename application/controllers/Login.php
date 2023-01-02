<?php
class Login extends CI_Controller {
    
    public function index(){
        $data['title'] = 'Login';
        $this->load->view('login', $data);
    }
    public function verify(){
        $this->form_validation->set_rules('txtuser', 'Username', 'required');
        $this->form_validation->set_rules('txtpass', 'Password', 'required|callback_check_user');

        if($this->form_validation->run() === true){
            if($this->session->user_lvl == 1){
                redirect('admin/home');
            }else{
                redirect('home');
            }
        }else{
            $this->index();
        }
    }
    public function check_user(){
        $username = $this->input->post('txtuser');
        $password = $this->input->post('txtpass');

        $this->load->model('login_model');
        $login = $this->login_model->login($username, $password);

        if($login['success']){
            $sess_data = array(
                'customer_id' => $login['data']['customer_id'],
                'user_lvl'=> $login['data']['user_lvl'],
                'islogged' => true
            );
            $this->session->set_userdata($sess_data);
            return true;
        }else{
            if(isset($login['isBlocked'])){
                $this->form_validation->set_message('check_user', 'This account is blocked. Check your email to unblock');
                return false;
            }
            $this->form_validation->set_message('check_user', 'Invalid Username/password. You have '.$login['attemptsLeft'].' attempts left');
            return false;
        }
    }
}
?>