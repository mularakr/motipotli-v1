<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
    Manage Cities
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i><?php echo $this->Html->link('Home',array('controller'=>'manageCities','action'=>'index'),array(
                'escape' => false));?> </a></li>
        <li class="active">Manage Cities</li>       
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box"><br>	
           <?php  echo $this->Form->create('City',array('url'=>array('controller'=>'manageCities','action'=>'admin_setCities'),'id'=>'frm1','method'=>'post','class'=>'form-horizontal','type'=>'file','autocomplete'=>'off','enctype'=>'multipart/form-data'));?>

          	<div class="form-group">
  				  <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Select State<span style="color:red">*</span></span></label>
  				  <div class="col-sm-8">
  				     <?php echo $this->Form->input('state_id',array('empty' => '--Select State--','placeholder'=>'State','type'=>'select','id'=>'state','onchange'=> 'getPermision(this.value)','class'=>'form-control','value'=>!is_null($stateId) ? $stateId : '','label' => false));?>
  				  </div> 
             <div class="col-sm-2">
              
            </div>             
			</div> 
            <div class="box-body">	            
              <table id="example2" class="table table-bordered ">
                <thead> 
                 <?php $paginator = $this->Paginator; ?>       
                 <tr >
                 	<th style="text-align:center">Sr.No</th>
                    <th style="text-align:center"><?php echo $paginator->sort('city', 'City Name')?></th>
                    <th style="text-align:center">Action                   
                    	<!-- <?php echo $this->Form->checkbox('checkAll', array('hiddenField' => false, 'id'=>'selectall','onclick'=>'checkedAll(frm1);'));?> -->
                    </th>                 
                </tr> 
                </thead>
                <tbody>	
                 <?php 
                   $cnt=($this->request->params['paging']['City']['page']-1) * $this->request->params['paging']['City']['limit'];
                   if(!empty($cities)){                
                   foreach($cities as $page):
                   $cnt+=1;
                   ?>
                   <tr>
                   	 <td style="text-align:center"><?php echo $cnt;?></td>
                   	 <td style="text-align:center"><?php echo $page['City']['city'];?></td>
                   	 <td style="text-align:center">                   	
                   	   <?php 
						$checked ='';
						if($page['City']['is_popular'] == '0')
						{
							$checked = 'checked';						
						}	
					  ?>
					  <?php 
					  echo $this->Form->input('id',array('label'=>false, 'hiddenField' => false,'name'=>'data[City][id]','type'=>'checkbox', 'value'=>$page['City']['id'],'checked'=>$checked,'div'=>array('class'=>'form-group custom-checkbox my')));

					  /*echo $this->Form->input('id',array('label'=>false, 'hiddenField' => false,'name'=>'data[City][value][][id]','type'=>'checkbox', 'value'=>$page['City']['id'],'checked'=>$checked,'div'=>array('class'=>'form-group custom-checkbox')));*/
					  ?>                                     
                   	 </td>
                   </tr>

                   <?php endforeach; }else{
                    ?>
                    <tr>
                        <td style="text-align:center;color:red" colspan="3">no record found</td>
                    </tr>
                    <?php }?>
                     <?php if(!empty($cities)){?>
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
                        </tr><?php }?>
                </tbody>
              </table>               
            </div>
           <!--  <div class="row">
			  <div class="col-md-8"></div>
			  <div class="col-md-4">
			  <?php 
			   if(!empty($cities)){?>
			  	<?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-success pull-right']) ?>
			  		<?php }?>
			  	</div>
			</div> -->
            <?php echo $this->Form->end();?>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
<script type="text/javascript">
	/*checked=false;
	function checkedAll (frm1) {
		var aa= document.getElementById('frm1'); 
		if (checked == false)
		{
			checked = true
		}
		else
		{
			checked = false
		}
		for (var i =0; i < aa.elements.length; i++)
		{ 
			aa.elements[i].checked = checked;
		}
	}*/
	jQuery.noConflict();
	jQuery(document).ready(function() 
	{	
		var id;
		var status;
		$(".my input:checkbox").change(function() {
		    var ischecked= $(this).is(':checked');
		    if(ischecked){
		    	
		    	id=$(this).val();
		    	status=true;
		    	
		    }else{
		    	
		    	id=$(this).val();
		    	status=false;		    	
		    }

		    $.ajax({
				type: 'POST',							
				url: '<?php echo Router::url(array('admin'=>true,'controller'=>'manageCities', 'action'=>'admin_changeCityStatus'));?>',
				data: 'id='+id+'&status='+status,
				success: function(jsonResponse) {
					var response = JSON.parse(jsonResponse);//$.parseJSON(jsonResponse);					
					if(response.status != 'success')
					{					
						element.val(!status);
					}					
					console.log(response.message);
					/*alert(response.message);*/
					}	
				});		  
		    
		}); 

	});
	function getPermision(roleId) {
		location.href = '<?php echo Router::url('index/'); ?>' + roleId;
	}
	</script>



