<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
    	Add New Category
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
				 <?php  echo $this->Form->create('Category',array('url'=>array('controller'=>'categories','action'=>'admin_add'),'method'=>'post','class'=>'form-horizontal','type'=>'file','autocomplete'=>'off','enctype'=>'multipart/form-data', 'id'=>'catformid'));?>
				  <div class="box-body">
					
					<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label"></label>
					  <div class="col-sm-10">	
					  	<span style="color:red;"><?php echo $this->Session->flash();?></span>	
					  </div>
					</div>

					
					<div class="form-group">
					  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Category Name<span style="color:red"></span></span></label>
					  <div class="col-sm-10">
						<?php echo $this->Form->input('name',array('placeholder'=>'Name','type'=>'text','class'=>'form-control','label' => false));?>	
					  </div>
					</div>


					<div class="form-group">
					  <label for="inputPassword3" class="col-sm-2 control-label"><span style="color:black">Category Image</span></label>
					  <div class="col-sm-10">
					  <?php echo $this->Form->input('catimage', array('type' => 'file','label' => false, 'id' => 'catprofileimage'));
						?>								
					  </div>
					</div>

					<div class="form-group">
						 <label for="inputPassword3" class="col-sm-2 control-label"><span style="color:black"></span></label>								 
					  <div class="col-sm-10">
						<?php 
						echo $this->Form->submit('Save',array('class'=>'btn block btn-success','div'=> false,'style' => 'float:left;margin-right: 10px'));
						echo $this->Html->link('Back', array('admin'=>true,'controller'=>'categories', 'action'=>'index'),array('class'=>'btn bg-navy'));
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

<script type="text/javascript">	 
	$.noConflict();
	$(document).ready(function(){

	$(document).on('change','#catprofileimage',function(){
		 var ext = $('#catprofileimage').val().split(".").pop().toLowerCase();
		if($.inArray(ext, ["jpg","png","gif","jpeg"]) == -1) {
			$(this).val('');
			alert('Please upload files having extensions: jpg,png,gif,jpeg');// false
		}else{
			return true;
			//alert('true');// true
		}
	});


	});

	jQuery("#catformid").validate({
  rules: {
    'data[Category][name]': { required: true},
    'data[Category][catimage]': { required: true},

  },
  messages: {
    'data[Category][name]': {required: "Please enter Category Name." },
    'data[Category][catimage]': {required: "Please Upload Image." },



  },
}); 
  </script> 
