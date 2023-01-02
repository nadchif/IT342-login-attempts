<?php
class Unblock_account extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = 'Unblock Account';
        $this->load->view('unblock_account', $data);
    }

    public function unblock($encrypted_email)
    {
        $this->load->model('unblock_account_model');
        $user = $this->unblock_account_model->findCustomer($encrypted_email);

        if ($user) {
            if ($this->uri->segment(2) == 'unblock') {
                $this->unblock_account_model->unblockAccount($user['cust_id']);
                $data['title'] = 'Account Unblocked Successfully';
                $data['message'] = 'You may now login again';
                $this->load->view('unblock_account_success', $data);
            } 
        } else {
            show_404();
        }
    }
}
