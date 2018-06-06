<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
    	Edit Faq
        <small></small>
      </h1>
      <ol class="breadcrumb">
         <li><a href=""><i class="fa fa-dashboard"></i><?php echo $this->Html->link('Home',array('controller'=>'faqs','action'=>'index'),array(
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
				 <?php  echo $this->Form->create('Faq',array('url'=>array('controller'=>'faqs','action'=>'admin_edit'),'method'=>'post','class'=>'form-horizontal','autocomplete'=>'off'));?>
				  <div class="box-body">
					  
					<div class="form-group">
					  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Question<span style="color:red">*</span></span></label>
					  <div class="col-sm-10">
						  <?php echo $this->Form->input('question',array('placeholder'=>'Question','type'=>'text','class'=>'form-control','required'=>'required','pattern' => '.*[^ ].*','label' => false));?>		
					  </div>
					</div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Answer<span style="color:red">*</span></span></label>
            <div class="col-sm-10">
            <?php echo $this->Form->textarea('answer', array('placeholder'=>'Answer','rows' => '5', 'cols' => '5', 'class'=>'form-control','required'=>'required','pattern' => '.*[^ ].*','label' => false));?>  
            </div>
          </div>
				

					<div class="form-group">
						 <label for="inputPassword3" class="col-sm-2 control-label"><span style="color:black"></span></label>								 
					  <div class="col-sm-10">					
						<?php 					
						echo $this->Form->submit('Save',array('class'=>'btn block btn-success','div'=> false,'style' => 'float:left;margin-right: 10px'));
						echo $this->Html->link('Back', array('admin'=>true,'controller'=>'faqs', 'action'=>'index'),array('class'=>'btn bg-navy'));

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
	});
  </script>