<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
    <head>
        <title>Administration Panel</title>
    </head>
    <body>
        <h1><?php echo $title ; ?></h1>
        Welcome Admin | 
        <a href="<?php echo base_url("Logout"); ?>" >Log Out </a><br/>
        <em>This page is restricted to unauthorized users. Only logged in users can see/access this page</em>
    </body>
</html>