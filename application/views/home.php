<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
    <head>
        <title>Home | <?php echo $this->session->customer_id; ?></title>
    </head>
    <body>
        <h1>Welcome</h1>
        Customer: <?php echo $this->session->customer_id; ?> | 
        <a href="<?php echo base_url("Logout"); ?>" >Log Out </a><br/>
        <em>This page is restricted to unauthorized users. Only logged in users can see/access this page</em>
    </body>
</html>