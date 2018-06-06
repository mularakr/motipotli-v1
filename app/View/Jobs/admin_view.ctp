<!-- FancyBoxCode-->
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Job Details
         <small></small>
      </h1>
      <ol class="breadcrumb">
         <li><a href=""><i class="fa fa-dashboard"></i><?php echo $this->Html->link('Home',array('admin'=>true,'controller'=>'jobs','action'=>'index'),array(
            'escape' => false));?> </a></li>
         <li class="active">Job Details</li>
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
                        <dd><?php echo $jobDetails['Job']['id']?></dd>
                        <hr>                      
                        <dt>Title</dt>
                        <dd><?php echo $jobDetails['Job']['title']?></dd>
                        <hr>
                        <dt>Positions</dt>
                        <dd><?php echo $jobDetails['Job']['positions']?></dd>
                        <hr>
                        <dt>Category</dt>
                        <dd><?php echo $jobDetails['Category']['name']?></dd>
                        <hr>
                        <dt>User</dt>
                        <dd><?php echo $jobDetails['User']['name']?></dd>
                        <hr>
                        <dt>Status</dt>
                        <dd><?php echo $jobDetails['Job']['status']?></dd>
                        <hr>
                        <dt>Address1</dt>
                        <dd><?php echo $jobDetails['Job']['address1']?></dd>
                        <hr>
                        <dt>Address2</dt>
                        <dd><?php echo $jobDetails['Job']['address2']?></dd>
                        <hr>
                        <dt>Pincode</dt>
                        <dd><?php echo $jobDetails['Job']['pincode']?></dd>
                        <hr>
                        <dt>Description</dt>
                        <dd><?php echo $jobDetails['Job']['description']?></dd>
                        <hr>
                        <dt>State</dt>
                        <dd><?php echo $jobDetails['Job']['state_id']?></dd>
                        <hr>
                        <dt>City</dt>
                        <dd><?php echo $jobDetails['Job']['city_id']?></dd>
                        <hr>
                        <dt>Start Date</dt>
                        <dd><?php echo $jobDetails['Job']['startdate']?></dd>
                        <hr>
                        <dt>End Date</dt>
                        <dd><?php echo $jobDetails['Job']['enddate']?></dd>
                        <hr>
                        <dt>Start Time</dt>
                        <dd><?php echo $jobDetails['Job']['starttime']?></dd>
                        <hr>
                        <dt>End Time</dt>
                        <dd><?php echo $jobDetails['Job']['endtime']?></dd>
                        <hr>
                        <dt>Allow Bids</dt>
                        <dd><?php echo $jobDetails['Job']['allowbids']?></dd>
                        <hr>
                        <dt>Id Proof</dt>
                        <dd><?php echo $jobDetails['Job']['idproof']?></dd>
                        <hr>
                        <dt>Include</dt>
                        <dd><?php echo $jobDetails['Job']['include']?></dd>
                        <hr>
                        <dt>Is Complete</dt>
                        <dd><?php echo $jobDetails['Job']['iscomplete']?></dd>
                        <hr>                    
                        <dt>Image</dt>
                        <dd>
                           <!--<div class="img-responsive djimage">	
                              <?php 
                                 if(!empty($user['User']['profileimg'])){	  
                                 ?>					
                              <a data-fancybox="gallery" href="<?php echo $pathvars['imagepath'] . '/profile_image/big/' . h($user['User']['profileimg']); ?>">
                              <img src="<?php echo $pathvars['imagepath'] . '/profile_image/thumb/' . h($user['User']['profileimg']); ?>"></a>
                              <?php }else{?>
                              <img src="<?php echo $pathvars['imagepath'] . '/profile_image/user.png'?>" height="42" width="42">
                              <?php }?>
                           </div>-->
                        </dd>
                        <hr>
                        </br>
                        <dt></dt>
                        <dd>
                           <?php 								
                              echo $this->Html->link('Back', array('admin'=>true,'controller'=>'jobs', 'action'=>'index'),array('class'=>'btn bg-navy' ));
                              ?>
                        </dd>
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

