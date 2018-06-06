<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
    List of Users
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i><?php echo $this->Html->link('Home',array('controller'=>'users','action'=>'index'),array(
                'escape' => false));?> </a></li>
        <li class="active">Users</li>       
      </ol>
    
		<?php  echo $this->Form->create('User',array( 'url'=>array('controller'=>'users','action'=>'index'),'method'=>'get','class'=>'form-horizontal','type'=>'file','autocomplete'=>'off','enctype'=>'multipart/form-data'));?>        		

  		<div class="SearchBar">
		  <?php echo $this->Form->input('search',array('placeholder'=>'Search by user or email','type'=>'text','class'=>'form-control','pattern' => '.*[^ ].*','label' => false,'style' => 'float:left;'));?>
		</div>
		<div class="SearchBtn">
		  <?php echo $this->Form->submit('Search',array('class'=>'btn block btn-success')); ?>
		</div>
  	<?php echo $this->Form->end();?>		
  	</section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
      		 <!--<?php echo $this->Html->link('Create', array('controller'=>'', 'action'=>''),array('class'=>'btn bg-navy margin'));  ?>-->           
            <div class="box-body">
              <table id="example2" class="table table-bordered ">
                <thead>
                 <span style="align=center;color:red" ><?php echo $this->Session->flash();?></span>
                 <?php $paginator = $this->Paginator; ?>
                 <tr >
                 	<th >Sr.No</th>
                    <th ><?php echo $paginator->sort('name', 'User Name')?></th>
                    <th >Email</th>
                   
                    <th >Status</th>
                    <th >Is Block</th>
                    <th >Action</th>
                </tr> 
                </thead>
                <tbody>
					<?php 
					$cnt=($this->request->params['paging']['User']['page']-1) * $this->request->params['paging']['User']['limit'];
					if(!empty($users)){
					foreach($users as $page):
					//	echo '<pre>'; print_r($page); die;
					$cnt+=1;
					?>
					<tr>
					    <td ><?php echo $cnt ?>&nbsp;</td>			
						<td ><?php echo h($page['User']['name']); ?>&nbsp;</td>
						<td ><?php echo $page['User']['email']; ?>&nbsp;</td>	
						
						

						<td class="">
							<?php if($page['User']['status']==0){
							?>
							<button class='statusClass' id="btnval_<?php echo $page['User']['id'];?>" name = "button" value ='Approved' userid = "<?php echo $page['User']['id'];?>" type = "button">Active</button>
							<?php }else{?>
							<button class='statusClass' id="btnval_<?php echo $page['User']['id'];?>" name = "button" value ='Disapproved' userid = "<?php echo $page['User']['id'];?>" type = "button">Inactive</button>
							<?php }?>
						</td>

						<td class="">
							<?php if($page['User']['status']==0){
							?>
							Unblock
							<?php }else{?>
							Block
							<?php }?>
						</td>


						<td class="actions" align="center" >
											
						<?php echo $this->Html->link('<span class="glyphicon glyphicon-eye-open" style="padding-right: 5px;margin-top: 10px;"></span>',array('action'=>'view', $page['User']['id']),array('rel'=>'tooltip','title'=>'View','escape' => false));?> 

 						<!--<?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil" style="padding-right: 5px;margin-top: 10px;"></span>',array('action' => 'edit', $page['User']['id']),array('confirm' => 'Are you sure you want to Edit this User?','rel'=>'tooltip','title'=>'Edit','escape' => false));	?>	-->

 						<?php echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span>',array('action' => 'delete', $page['User']['id']),array('confirm' => 'Are you sure you want to Delete this User?','rel'=>'tooltip','Delete'=>'View','escape' => false));	?>				
 							
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
  <!-- /.content-wrapper -->

  
  
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
				url: '<?php //echo Router::url(array('controller'=>'App', 'action'=>'change_status'));?>',
				data: 'id='+element.data('id')+'&status='+currentStatus+'&cnt='+element.data('cnt'),

				//data: 'id='+element.data('id')+'&status='+currentStatus+'&cnt='+element.data('cnt')
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
		//return false;
		//location.reload(true);
		window.location.reload();
	
		});
			
	});*/

	$(document).ready(function() 
	{
		$(".statusClass").click(function() {
			//alert('here');
			var fired_button = $(this).val();
			//alert(fired_button);
			var userid = $(this).attr('userid');
			//alert(userid); return false;
				var routeurl = '<?php echo Router::url('/', true);?>'
				var confirmation = confirm("Update User Status");
				//alert(routeurl+'Users/change_status'); return false;
				if(confirmation){
					//alert(confirmation); return false;
				
			$.ajax
	          ({
	          type: "POST",
	         	//url: 'http://52.55.215.33/motipotli/Users/change_status',
	         	url: routeurl+'Users/change_status',
	          	data: {action:fired_button, userid:userid},
		          success: function(res)
		          {
		          	//console.log(res); return false;
			          	if(res == 'success'){
			          		//console.log(res); return false;
			          		if(fired_button == 'Approved'){
			          			//alert(fired_button);
			          			$("#btnval_"+userid).attr('value', 'Disapproved');
			          			$("#btnval_"+userid).html('Inactive');

			          	}else {
			          		//alert(fired_button);
			          		$("#btnval_"+userid).attr('value', 'Approved');
			          		$("#btnval_"+userid).html('Active');

			          	}
			          }
			      }
	      });
	    }
	});
	
});
  </script> 
 <style type="text/css">
  	
.SearchBar,
.SearchBtn{
  float: left;
}
  </style>