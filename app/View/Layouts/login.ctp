<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <title>Admin Login - MotiPotli</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- Tell the browser to be responsive to screen width --> 
	  <!-- Bootstrap 3.3.5 -->
	  <link rel="stylesheet" href="<?=$basepath ?>adminfile/bootstrap/css/bootstrap.min.css">
	  <!-- Font Awesome -->
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	  <!-- Ionicons -->
	  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	  <!-- Theme style -->
	  <link rel="stylesheet" href="<?=$basepath ?>adminfile/dist/css/AdminLTE.min.css">
	  <!-- iCheck -->
	  <link rel="stylesheet" href="<?=$basepath ?>adminfile/plugins/iCheck/square/blue.css">

		<!-- jQuery 2.2.0 -->
		<script src="<?=$basepath ?>adminfile/plugins/jQuery/jQuery-2.2.0.min.js"></script>
		<!-- Bootstrap 3.3.5 -->
		<script src="<?=$basepath ?>adminfile/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?=$basepath ?>adminfile/bootstrap/js/jquery.min.js"></script>
		<!-- iCheck -->
		<script src="<?=$basepath ?>adminfile/plugins/iCheck/icheck.min.js"></script>
		<script>
		  $(function () {
			$('input').iCheck({
			  checkboxClass: 'icheckbox_square-blue',
			  radioClass: 'iradio_square-blue',
			  increaseArea: '20%' // optional
			});
		  });
		</script>	

    </head>
    
    <body class="hold-transition login-page">
		<?php
		echo $this->fetch('content');
		?>
    </body>
</html>
