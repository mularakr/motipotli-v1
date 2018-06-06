<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title_for_layout?></title>
        <link rel="shortcut icon" type="image/png" href="<?=$basepath ?>img/favicon.ico"/>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!--Mian file-->
		
		<script src="<?=$basepath ?>adminfile/dist/js/jquery.min.js"></script>
		<!-- Font Awesome -->
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">			
		<!--Css-->
		<link rel="stylesheet" href="<?=$basepath ?>adminfile/dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="<?=$basepath ?>adminfile/dist/css/skins/_all-skins.min.css">
		<link rel="stylesheet" href="<?=$basepath ?>adminfile/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">    

		<link rel="stylesheet" href="<?=$basepath ?>adminfile/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?=$basepath ?>adminfile/plugins/datepicker/datepicker3.css">
	   <!--DateTimePiker-->
	   <link rel="stylesheet" href="<?=$basepath ?>adminfile/plugins/datetimepicker/bootstrap-datetimepicker.css">
		<!--<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>-->
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!--Script-->
		<!-- jQuery 2.2.0 -->
		<script src="<?=$basepath ?>adminfile/plugins/jQuery/jQuery-2.2.0.min.js"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
		 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script>
		  $.widget.bridge('uibutton', $.ui.button);
		</script>
		<script src="<?=$basepath ?>adminfile/bootstrap/js/bootstrap.min.js"></script>

		<script src="<?=$basepath ?>adminfile/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="<?=$basepath ?>adminfile/plugins/sparkline/jquery.sparkline.min.js"></script>

		<script src="<?=$basepath ?>adminfile/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>		
		<script src="<?=$basepath ?>adminfile/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
		<script src="<?=$basepath ?>adminfile/plugins/knob/jquery.knob.js"></script>
		<script src="<?=$basepath ?>adminfile/plugins/daterangepicker/daterangepicker.js"></script>
		<script src="<?=$basepath ?>adminfile/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="<?=$basepath ?>adminfile/plugins/slimScroll/jquery.slimscroll.min.js"></script>
		<script src="<?=$basepath ?>adminfile/plugins/fastclick/fastclick.js"></script>
		<script src="<?=$basepath ?>adminfile/dist/js/demo.js"></script>
		<script src="<?=$basepath ?>adminfile/dist/js/pages/dashboard.js"></script>
		<script src="<?=$basepath ?>adminfile/plugins/morris/morris.min.js"></script>

		<script src="<?=$basepath ?>adminfile/dist/js/jquery.validate.js"></script>
		<script src="<?=$basepath ?>adminfile/dist/js/myvalidation.js"></script>

    </head>    
    <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
		<?php
		echo $this->element('header');
		echo $this->fetch('content');
		echo $this->element('footer');
		?>
	</div>
	
    </body>
    <script src="<?=$basepath ?>adminfile/dist/js/app.min.js"></script>	
</html>
