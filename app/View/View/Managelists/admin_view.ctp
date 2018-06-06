<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
    	Content Details
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i><?php echo $this->Html->link('Home',array('controller'=>'managelists','action'=>'admin_list'),array(
            'escape' => false));?> </a></li>
         <li class="active">Lists</li> 
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
				 <!-- Horizontal Form -->
			  <div class="box box-info">							
				  <div class="box-body" style="overflow-wrap: break-word;">
				  <dl class="dl-horizontal" style="background-color:#fcfcfc">				  	
				  	<dt>Title</dt>
				  	<dd><?php echo $managelists['Managelist']['listitem']?></dd><hr></br>
				  	<dt>Content</dt>
				  	<dd><?php echo $managelists['Managelist']['content']?></dd><hr></br>				  	
		  			<dd>
		  			<?php 								
						echo $this->Html->link('Back', array('controller'=>'managelists', 'action'=>'list'),array('class'=>'btn bg-navy' ));
					?></dd>							  	
				  </dl>													
				  </div>              							
			  </div>
             
        </div>
        </div>
        </div>
      </div>
    </section>
  </div>