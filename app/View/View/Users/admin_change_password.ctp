<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
   		Change Password
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
						  
							 <?php  echo $this->Form->create('User',array( 'url'=>array('admin'=>true,'controller'=>'users','action'=>'changePassword'),'method'=>'post','class'=>'form-horizontal','type'=>'file','autocomplete'=>'off','enctype'=>'multipart/form-data'));?>
							  <div class="box-body">
								 
								 <span style="align=center;color:red" ><?php echo $this->Session->flash();?></span>
								 
								<div class="form-group">
								  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Current Password</span></label>
								  <div class="col-sm-8">
									  <?php echo $this->Form->input('password',array('placeholder'=>'Current Password','required'=>'required','type'=>'password','class'=>'form-control','label' => false));?>	

								  </div>
								</div>
								<div class="form-group">
								  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">New Password</span></label>
								  <div class="col-sm-8">
									  <?php echo $this->Form->input('new_password',array('placeholder'=>'New Password','required'=>'required','type'=>'password','class'=>'form-control','id'=>'newpass','label' => false));?>		
								  </div>
								</div>
								<div class="form-group">
								  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Confirm New Password</span></label>
								  <div class="col-sm-8">
									  <?php echo $this->Form->input('confirm_new_password',array('placeholder'=>'Confirm New Password','required'=>'required','type'=>'password','class'=>'form-control','id'=>'cnfnewpass','label' => false));?>		
								  </div>
								</div>		
								<div class="form-group">									
									<div class="col-sm-10"><label for="inputEmail3" class="col-sm-2 control-label"></label>		
										<div id="divCheckPasswordMatch"></div>
									</div>
								</div>
								<div class="box-footer">
									 <label for="inputPassword3" class="col-sm-2 control-label"><span style="color:black"></span></label>								 
								  <div class="col-sm-10">
									<?php 
									echo $this->Form->submit('Save',array('class'=>'btn block btn-success','div'=> false,'style' => 'float:left;margin-right: 10px','id'=>'submit')); 
									echo $this->Html->link('Back', array('controller'=>'users', 'action'=>'index'),array('class'=>'btn bg-navy' ));
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

  
  
<script type="text/javascript">	 
	$.noConflict();
	$(document).ready(function() 
	{	
		$('#cnfnewpass').on('keyup', function () {
			var password = $("#newpass").val();
			var confirmPassword = $("#cnfnewpass").val();
			if (password != confirmPassword) 
			{
				$("#divCheckPasswordMatch").html("Passwords do not match!").css('color', 'red');
				$('#submit').prop('disabled' , true);
				
			} else 
			{
				$("#divCheckPasswordMatch").html("Passwords match").css('color', 'green');
				//$("#divCheckPasswordMatch").html("Passwords match.").hide();		
				$('#submit').prop('disabled' , false);
			}
		});
			
			//Upload only mp4 video
			$(document).on('change','#video1',function(){
			 var ext = $('#video1').val().split(".").pop().toLowerCase();
			if($.inArray(ext, ["mp4"]) == -1) {
				$(this).val('');
				alert('Please upload files having extensions: mp4');// false
			}else{
				return true;
				//alert('tru');// true
			}
			});
			
			
			
			
			
		});
  </script> 


