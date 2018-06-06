<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
    	Add New User
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
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
				 <?php  echo $this->Form->create('User',array('url'=>array('admin'=>true,'controller'=>'users','action'=>'admin_add'),'method'=>'post','class'=>'form-horizontal','type'=>'file','autocomplete'=>'off','enctype'=>'multipart/form-data'));?>
				  <div class="box-body">
					
					<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label"></label>
					  <div class="col-sm-10">	
					  	<span style="color:red;"><?php echo $this->Session->flash();?></span>	
					  </div>
					</div>

					<div class="form-group">
					  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Name<span style="color:red">*</span></span></label>
					  <div class="col-sm-10">
						<?php echo $this->Form->input('name',array('placeholder'=>'Name','type'=>'text','class'=>'form-control','label' => false));?>	
					  </div>
					</div>

					<div class="form-group">
					  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Email<span style="color:red">*</span></span></label>
					  <div class="col-sm-10">
						<?php echo $this->Form->input('email',array('placeholder'=>'Email','type'=>'text','class'=>'form-control','label' => false));?>	
					  </div>
					</div>

					<div class="form-group">
					  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Password<span style="color:red">*</span></span></label>
					  <div class="col-sm-10">
						<?php echo $this->Form->input('password',array('placeholder'=>'Password','type'=>'password','class'=>'form-control','label' => false));?>	
					  </div>
					</div>

					<div class="form-group">
					  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">State<span style="color:red">*</span></span></label>
					  <div class="col-sm-10">
						<?php echo $this->Form->input('state_id',array('placeholder'=>'State','type'=>'select','id'=>'state','class'=>'form-control','label' => false));?>	
					  </div>
					</div>
					<div class="form-group">
					  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">City<span style="color:red">*</span></span></label>
					  <div class="col-sm-10">
						<!--<?php echo $this->Form->input('city_id',array('placeholder'=>'City','type'=>'select','class'=>'form-control','id'=>'city','label' => false));?>	-->
						<?php echo $this->Form->input('city_id', array('id' =>'city','empty' => '--Select City--','options' => '$city','class'=>'form-control','label' => false));?>
		
					  </div>
					</div>

					<div class="form-group">
					  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Phone<span style="color:red"></span></span></label>
					  <div class="col-sm-10">
						<?php echo $this->Form->input('phone',array('placeholder'=>'Phone','type'=>'text','class'=>'form-control','label' => false));?>	
					  </div>
					</div>

					<!--<div class="form-group">
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
					</div>-->
					
					<div class="form-group">
					  <label for="inputPassword3" class="col-sm-2 control-label"><span style="color:black">Profile Image</span></label>
					  <div class="col-sm-10">
					  <?php echo $this->Form->input('profileimg', array('type' => 'file','id'=>'image','label' => false));
						?>								
					  </div>
					</div>

					<div class="form-group">
						 <label for="inputPassword3" class="col-sm-2 control-label"><span style="color:black"></span></label>								 
					  <div class="col-sm-10">
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
<!--<script type="text/javascript">

   $.noConflict();
   $(document).ready(function() 
   {	
   
   		
   });    
</script>-->
<script type="text/javascript">
	$(document).ready(function() {
		$.noConflict();
		$("#state").on('change',function() {		
			var id = $(this).val();
			$("#loding2").show();
			$("#city").find('option').remove();
			if (id) {
				var dataString = 'id='+ id;
				$.ajax({
					type: "POST",
					url: '<?php echo Router::url(array('admin'=>true,"controller" => "users", "action" => "getCities")); ?>',
					data: dataString,
					cache: false,
					success: function(html) {
						$("#loding2").hide();
						$.each(html, function(key, value) {              
							$('<option>').val(key).text(value).appendTo($("#city"));
						});
					} 
				});
			}	
		});
	});
</script>
