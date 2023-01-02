<?php
class Login_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function send_block_notice_email($email)
    {
        $this->load->helper('email');
        $this->load->library('email');

        if (valid_email($email)) {
            $this->email->from('lslayugan@domain.com', 'Leon Dustin');
            $this->email->to($email);
            $this->email->set_mailtype("html");
            $this->email->subject('Account Blocked');
 
            $body = '<h1>Account Blocked</h1><p>Your account has been blocked because login attempts were exceeded.</p><p>You can unblock your account by visiting <a href="'.base_url().'unblock_account/unblock/'.md5($email).'">'.base_url().'unblock_account/unblock/'.md5($email).'</a></p>';

            $this->email->message($body);

            if (!$this->email->send()) {
                // echo "Email not sent \n" . $this->email->print_debugger();
            } else {
                // echo 'Email was successfully sent to ' .$email;
            }
        } else {
            // echo 'Email is not correct. Please try again.';
        }
    }
    public function login($username, $password)
    {
        $user_condition = array('user_name' => $username);
        $rs = $this->db->get_where('users', $user_condition); 
        $row_count = count((array)$rs->row_array());
        if ($row_count > 0) {
            $is_blocked = $rs->row_array()['isBlocked'];
            if ($is_blocked) {
                return array('success' => FALSE, 'isBlocked' => TRUE);
            }
        }

        $condition_array = array(
            'user_name' => $username,
            'user_pass' => md5($password),
        );

        $rs = $this->db->get_where('users', $condition_array);
        $row_count = count((array)$rs->row_array());

        if ($row_count > 0) {
            return array('success' => TRUE, 'data' => $rs->row_array());
        } else {
            $user_rs = $this->db->get_where('users',  $user_condition);
            $row_count = count((array)$user_rs->row_array());
            if ($row_count > 0) {
                $attempts = $user_rs->row_array()['loginAttempts'];
                $attemptsLeft = 2 - $attempts;
                if ($attemptsLeft < 0) {
                    $attemptsLeft = 0;
                }
                $updates = array('loginAttempts' => $attempts + 1);
                if ($attemptsLeft == 0) {
                    $updates['isBlocked'] = 1;
                    $cust_id = $user_rs->row_array()['cust_id'];
                    $customer_rs = $this->db->get_where('customers', array('cust_id' => $cust_id));
                    $this->send_block_notice_email($customer_rs->row_array()['cust_email']);
                }
                $this->db->where('user_name', $username);
                $this->db->update('users', $updates);
                return array('success' => FALSE, 'attemptsLeft' => $attemptsLeft);
            }
            return array('success' => FALSE, 'attemptsLeft' => 0);
        }
    }
}
