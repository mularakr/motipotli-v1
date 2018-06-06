<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         List of Categories
         <small></small>
      </h1>
      <ol class="breadcrumb">
         <li><a href=""><i class="fa fa-dashboard"></i><?php echo $this->Html->link('Home',array('controller'=>'categories','action'=>'index'),array(
            'escape' => false));?> </a></li>
         <li class="active">Categories</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-body">
                  <table id="example2" class="table table-bordered ">
                     <thead>
                        <span style="align=center;color:red" ><?php echo $this->Session->flash();?></span>
                        <?php $paginator = $this->Paginator; ?>
                        <tr >
                           <th style="text-align:center">Sr.No</th>
                           <th style="text-align:center"><?php echo $paginator->sort('name', 'Name')?></th>
                           <th style="text-align:center">Status</th>
                           <th style="text-align:center">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                           $cnt=($this->request->params['paging']['Category']['page']-1) * $this->request->params['paging']['Category']['limit'];
                           if(!empty($categories)){
                           foreach($categories as $page):
                           $cnt+=1;
                           ?>
                        <tr>
                           <td style="text-align:center"><?php echo $cnt ?>&nbsp;</td>
                           <td ><?php echo h($page['Category']['name']); ?>&nbsp;</td>

                           <!-- <td>
                             	<?php $options = array('0'=>'Approved','1' => 'Disapproved');
									echo $this->Form->select('status', $options, array('empty'=>false, 'name'=>'data[Category][status]', 'default'=>$page['Category']['status'], 'class'=>'form-control ddStatus', 'data-cat_id'=>$page['Category']['id']));
								?>			
                           </td> -->

<td class="">
<?php if($page['Category']['status']==0){
?>
<button class='catstatusClass' id="btnval1_<?php echo $page['Category']['id'];?>" name = "button" value ='Approved' userid = "<?php echo $page['Category']['id'];?>" type = "button">Approved</button>
<?php }else{?>
<button class='catstatusClass' id="btnval1_<?php echo $page['Category']['id'];?>" name = "button" value ='Disapproved' userid = "<?php echo $page['Category']['id'];?>" type = "button">Disapproved</button>
<?php }?>
</td> 


                           <td class="actions" align="center" >
                              <?php echo $this->Html->link('<span class="glyphicon glyphicon-eye-open" style="padding-right: 5px;margin-top: 10px;"></span>',array('action'=>'view', $page['Category']['id']),array('rel'=>'tooltip','title'=>'View','escape' => false));?> 
                              <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil" style="padding-right: 5px;margin-top: 10px;"></span>',array('action' => 'edit', $page['Category']['id']),array('confirm' => 'Are you sure you want to Edit this Category?','rel'=>'tooltip','title'=>'Edit','escape' => false));	?>	
                              <!--<?php echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span>',array('action' => 'delete', $page['Category']['id']),array('confirm' => 'Are you sure you want to Delete this Category?','rel'=>'tooltip','Delete'=>'View','escape' => false));	?>	-->			
                           </td>
                        </tr>
                        <?php endforeach; }else{
                           ?>
                        <tr>
                           <td style="text-align:center;color:red" colspan="4">no record found</td>
                        </tr>
                        <?php }?>
                        <tr>
                           <td colspan="7">
                              <div id="paging_div">
                                 <?php  echo $this->Paginator->counter(array(
                                    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                                    ));?>
                                 </br></br>
                                 <?php 
                                    //*** PAGINATION NUMBER'S
                                    echo $paginator->first("First");
                                    if($paginator->hasPrev())
                                    {
                                    	echo "&nbsp;".$paginator->prev("Prev");
                                    }
                                    	echo "&nbsp;".  $paginator->numbers(array('modulus' => 2));
                                    if($paginator->hasNext())
                                    {
                                    	echo "&nbsp;".$paginator->next("Next");
                                    }
                                    	echo "&nbsp;".  $paginator->last("Last");
                                    ?>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
<script type="text/javascript">	 
	$.noConflict();
	/*$(document).ready(function() 
	{	
			//change status
			$(document).on('change', '.ddStatus', function(e) {	
			var currentStatus = $(this).val();	
			
			var status='';
			if(currentStatus==1){
				status='Are you sure you want to Approved?';
			}else{
				status='Are you sure you want to Disapproved?';
			}			
			var success = confirm(status);
			if(success==true){
				var element = $(this);	
					$.ajax({
					type: 'POST',							
					url: '<?php echo Router::url(array('admin'=>true,'controller'=>'categories', 'action'=>'admin_category_status'));?>',
					data: 'cat_id='+element.data('cat_id')+'&status='+currentStatus,
					success: function(jsonResponse) {
						var response = JSON.parse(jsonResponse);//$.parseJSON(jsonResponse);					
						if(response.status != 'success')
						{					
							element.val(!currentStatus);
						}					
						alert(response.message);
						}	
					});
				}			
			window.location.reload();
		
			});
			
		});*/

$(document).ready(function() 
   {
      $(".catstatusClass").click(function() {
         //alert('here');
         var fired_button = $(this).val();
         //alert(fired_button);
         var userid = $(this).attr('userid');
         //alert(userid); return false;
            var routeurl = '<?php echo Router::url('/', true);?>'
            var confirmation = confirm("Update Category Status");
            //alert(routeurl+'Category/cat_change_status'); return false;
            if(confirmation){
               //alert(confirmation); return false;
            
         $.ajax
             ({
             type: "POST",
               //url: 'http://52.55.215.33/motipotli/Users/change_status',
               url: routeurl+'Categories/cat_change_status',
               data: {action:fired_button, userid:userid},
                success: function(res)
                {
                  //console.log(res); return false;
                     if(res == 'success'){
                        //console.log(res); return false;
                        if(fired_button == 'Approved'){
                           //alert(fired_button);
                           $("#btnval1_"+userid).attr('value', 'Disapproved');
                           $("#btnval1_"+userid).html('Disapproved');

                     }else {
                        //alert(fired_button);
                        $("#btnval1_"+userid).attr('value', 'Approved');
                        $("#btnval1_"+userid).html('Approved');

                     }
                   }
               }
         });
       }
   });
   
});

  </script> 
