<?php
class Forgot_password extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = 'Forgot Password';
        $this->load->view('Forgot_password', $data);
    }

    public function verify()
    {
        $this->form_validation->set_rules(
            'txtemail',
            'E-mail Address',
            'required|trim|valid_email|callback_check_email'
        );

        if ($this->form_validation->run()) {
            $this->load->library('email');

            $this->email->from('lslayugan@domain.com', 'Leon Dustin');
            $this->email->to('mjlayugan@domain.com');
            $this->email->subject('Reset Password Link');
            $this->email->message('<p>To reset your password, please click this link: '
                . base_url('forgot password/reset/' . md5($this->input->post('txtemail'))) . '</p>');

            $this->email->send();

            $data['title'] = 'Reset Password Link Sent';
            $data['message'] = 'Please click the Reset Password link sent to your email to reset your password';
            $this->load->view('forgot_password_email_sent', $data);
        } else {
            $this->index();
        }
    }
    public function check_email($email)
    {
        $this->load->model('forgot_password_model');
        $emailExists = $this->forgot_password_model->isEmailExists($email);

        if ($emailExists) {
            return true;
        } else {
            $this->form_validation->set_message('check email', '%s entered does not exist!');
            return false;
        }
    }
    public function reset($encrypted_email)
    {
        $this->load->model('forgot_password_model');
        $user = $this->forgot_password_model->findCustomer($encrypted_email);

        if ($user) {
            if ($this->uri->segment(4) == 'verify') {
                $this->form_validation->set_rules('txtpass', 'New Password', 'required');
                $this->form_validation->set_rules('txtrepass', 'Re-type Password', 'required|matches[txtpass]');
            }

            if ($this->form_validation->run()) {
                $this->forgot_password_model->updatePassword($user['cust_id']);
                $data['title'] = 'Password Changed Successfully';
                $data['message'] = 'You may now login using your new password.';
                $this->load->view('forgot_password_success', $data);
            } else {
                $data['title'] = 'Reset Password';
                $this->load->view('forgot_password_reset', $data);
            }
        } else {
            show_404();
        }
    }
}
