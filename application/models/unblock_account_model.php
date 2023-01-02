<?php
class unblock_account_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function isEmailExists($email)
    {
        $rs = $this->db->get_where('customers', array('cust_email' => $email));
        return $rs->row_array();
    }
    public function findCustomer($encrypted_email)
    {
        $rs = $this->db->get_where('customers', array('md5(cust_email)' => $encrypted_email));
        return $rs->row_array();
    }

    public function unblockAccount($cust_id)
    {
        $this->db->where('cust_id', $cust_id);
        return $this->db->update('users', array('isBlocked' => 0, 'loginAttempts' => 0));
    }
}
