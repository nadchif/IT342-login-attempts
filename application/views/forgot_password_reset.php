<!DOCTYPE html>
<html>
<head>
<title><?php echo $title; ?></title>
</head>
<body>
<h1><?php echo $title; ?></h1>
<?php
echo validation_errors();
echo form_open('forgot_password/reset/'. $this->uri->segment(3).'/verify');

echo form_label('New Password', 'txtpass');
echo form_password('txtpass', '', 'id="txtpass"').'<br/>';

echo form_label('Re-type Password', 'txtrepass');
echo form_password('txtrepass', '', 'id="txtrepass"').'<br/>';

echo form_submit('btnchange','Change Password');

echo form_close();
?>
</body>
</html>