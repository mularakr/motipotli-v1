 <link rel="stylesheet" href="<?=$basepath ?>adminfile/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=$basepath ?>adminfile/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=$basepath ?>adminfile/dist/css/skins/_all-skins.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?=$basepath ?>adminfile/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
    	Edit User
        <small></small>
      </h1>
      <ol class="breadcrumb">
         <li><a href=""><i class="fa fa-dashboard"></i><?php echo $this->Html->link('Home',array('controller'=>'users','action'=>'index'),array(
                'escape' => false));?> </a></li>
        <li class="active"></li>       
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
				 <!-- Horizontal Form -->
						  <div class="box box-info">
							 <?php  echo $this->Form->create('User',array( 'url'=>array('controller'=>'users','action'=>'admin_edit'),'method'=>'post','class'=>'form-horizontal','type'=>'file','autocomplete'=>'off','enctype'=>'multipart/form-data'));?>
							  <div class="box-body">
								  
								<div class="form-group">
								  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Search Users</span></label>
								  <div class="col-sm-10">

									  <?php echo $this->Form->input('name',array('placeholder'=>'Name','type'=>'text','class'=>'form-control','required'=>'required','pattern' => '.*[^ ].*','label' => false));?>		
								  </div>
								</div>

								<div class="form-group">
								  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Email<span style="color:red">*</span></span></label>
								  <div class="col-sm-10">
									  <?php echo $this->Form->input('email',array('placeholder'=>'email','type'=>'text','class'=>'form-control','required'=>'required','pattern' => '.*[^ ].*','label' => false));?>		
								  </div>
								</div>

								<div class="form-group">
								  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Password<span style="color:red">*</span></span></label>
								  <div class="col-sm-10">
									  <?php echo $this->Form->input('password',array('placeholder'=>'password','type'=>'password','class'=>'form-control','required'=>'required','pattern' => '.*[^ ].*','label' => false));?>		
								  </div>
								</div>

								<div class="form-group">
								  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">State<span style="color:red">*</span></span></label>
								  <div class="col-sm-10">
									<?php echo $this->Form->input('state_id',array('placeholder'=>'State','type'=>'select','class'=>'form-control','pattern' => '.*[^ ].*','required'=>'required','label' => false));?>	
								  </div>
								</div>
								<div class="form-group">
								  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">City<span style="color:red">*</span></span></label>
								  <div class="col-sm-10">
									<?php echo $this->Form->input('city_id',array('placeholder'=>'City','type'=>'select','class'=>'form-control','pattern' => '.*[^ ].*','required'=>'required','label' => false));?>	
								  </div>
								</div>

								<div class="form-group">
								  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Phone<span style="color:red"></span></span></label>
								  <div class="col-sm-10">
									<?php echo $this->Form->input('phone',array('placeholder'=>'Phone','type'=>'text','class'=>'form-control','pattern' => '.*[^ ].*','label' => false));?>	
								  </div>
								</div>

								<div class="form-group">
								  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Provider<span style="color:red"></span></span></label>
								  <div class="col-sm-10">
									<?php echo $this->Form->input('provider',array('placeholder'=>'Provider','type'=>'text','class'=>'form-control','pattern' => '.*[^ ].*','label' => false));?>	
								  </div>
								</div>
								<div class="form-group">
								  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Company<span style="color:red"></span></span></label>
								  <div class="col-sm-10">
									<?php echo $this->Form->input('company',array('placeholder'=>'Company','type'=>'text','class'=>'form-control','pattern' => '.*[^ ].*','label' => false));?>	
								  </div>
								</div>

								<div class="form-group">
								  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Location<span style="color:red"></span></span></label>
								  <div class="col-sm-10">
									<?php echo $this->Form->input('location',array('placeholder'=>'Location','type'=>'text','class'=>'form-control','pattern' => '.*[^ ].*','label' => false));?>	
								  </div>
								</div>

								<div class="form-group">
								  <label for="inputPassword3" class="col-sm-2 control-label"><span style="color:black">Select Image</span></label>
								  <div class="col-sm-10">
								  <?php echo $this->Form->input('profileimg', array('type' => 'file','id'=>'image','label' => false));
								   ?>
								  </div>
								</div>

								<div class="form-group">
									 <label for="inputPassword3" class="col-sm-2 control-label"><span style="color:black"></span></label>								 
								  <div class="col-sm-10">
									<!--<?php echo $this->Form->submit('Save',array('class'=>'btn btn-info')); 	?>-->
									<?php 
									 	
								echo $this->Form->submit('Save',array('class'=>'btn block btn-success','div'=> false,'style' => 'float:left;margin-right: 10px'));
									echo $this->Html->link('Back', array('admin'=>true,'controller'=>'users', 'action'=>'index'),array('class'=>'btn bg-navy'));

									?>
								  </div>
								</div>		
							  </div>              
							<?php echo $this->Form->end();?>
						  </div>
             
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->