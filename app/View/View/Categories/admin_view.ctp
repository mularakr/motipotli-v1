<!-- FancyBoxCode-->
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
    	Category Details
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i><?php echo $this->Html->link('Home',array('controller'=>'categories','action'=>'index'),array(
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
				  	<dt>ID</dt>
				  	<dd><?php echo $category['Category']['id']?></dd><hr></br>
				  	<dt>Name</dt>
				  	<dd><?php echo $category['Category']['name']?></dd><hr></br>
				  	<!--<dt>Status</dt>
				  	<dd><?php echo $category['Category']['status']; ?></dd><hr></br>-->
				  	<dt>Image</dt>
				  	<dd><div class="img-responsive djimage">	
				  		<?php 
				  		if(!empty($category['Category']['catimage'])){	  
				  		?>					
						  <a data-fancybox="gallery" href="<?php echo $pathvars['imagepath'] . '/category/big/' . h($category['Category']['catimage']); ?>">
						  <img src="<?php echo $pathvars['imagepath'] . '/category/thumb/' . h($category['Category']['catimage']); ?>"></a>
						  <?php }else{?>
						  <img src="<?php echo $pathvars['imagepath'] . '/profile_image/user.png'?>" height="42" width="42">
						  <?php }?>

						</div></dd><hr></br>
				  	<dt></dt>
		  			<dd>
		  			<?php 								
						echo $this->Html->link('Back', array('controller'=>'categories', 'action'=>'index'),array('class'=>'btn bg-navy' ));
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
  <!-- /.content-wrapper -->
<div id="fileDisplayArea"></div>

<!-- To show image in a fancy box -->
<script type="text/javascript">	 
	var $= jQuery.noConflict();
	$(document).ready(function() 
		{		
			//Show Image
		$('.fancybox').fancybox();
		// Change title type, overlay closing speed
		$(".fancybox-effects-a").fancybox({
			helpers: {
				title : {
					type : 'outside'
				},
				overlay : {
					speedOut : 0
				}
			}
		});
	

		});
  </script> 


