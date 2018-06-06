<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
    	Faq Details
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
				  <div class="box-body" style="overflow-wrap: break-word;">
				  <dl class="dl-horizontal" style="background-color:#fcfcfc">
				  	<!--<dt>ID</dt>
				  	<dd><?php echo $faq['Faq']['id']?></dd><hr></br>-->
				  	<dt>Question</dt>
				  	<dd><?php echo $faq['Faq']['question']?></dd><hr></br>
				  	<dt>Answer</dt>
				  	<dd><?php echo $faq['Faq']['answer']?></dd><hr></br>
				  	<!--<dt>Status</dt>
				 	<dd><?php echo $faq['Faq']['status']; ?></dd><hr></br>-->
		  			<dd>
		  			<?php 								
						echo $this->Html->link('Back', array('controller'=>'faqs', 'action'=>'index'),array('class'=>'btn bg-navy' ));
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