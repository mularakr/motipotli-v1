<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Manage Content
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
               <div class="box-body">
                  <table id="example2" class="table table-bordered ">
                     <thead>
                        <span style="align=center;color:red" ><?php echo $this->Session->flash();?></span>
                        <?php $paginator = $this->Paginator; ?>
                        <tr >
                           <th style="text-align:center">Sr.No</th>                          
                            <th style="text-align:center">Title</th>
                            <th style="text-align:center">Content</th>                         
                           <th style="text-align:center">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                         <?php 
                           $cnt=($this->request->params['paging']['Managelist']['page']-1) * $this->request->params['paging']['Managelist']['limit'];
                           if(!empty($managelists)){
                          // echo "<pre>";print_r($managelists);die;
                           foreach($managelists as $page):
                           $cnt+=1;
                           ?> 
                        <tr>
                          <td style="text-align:center"><?php echo $cnt ?>&nbsp;</td>
                          <!-- substr($value['Job']['description'], 0, 80); -->
						  <td style="text-align:center"><?php echo $page['Managelist']['listitem'] ?>&nbsp;</td>
                          <td style="text-align:center"><?php echo substr($page['Managelist']['content'], 0, 80);?>&nbsp;</td>                          
                         
                           <td class="actions" align="center" >
                           <?php echo $this->Html->link('<span class="glyphicon glyphicon-eye-open" style="padding-right: 5px;margin-top: 10px;"></span>',array('action'=>'view', $page['Managelist']['id']),array('rel'=>'tooltip','title'=>'View','escape' => false));?>
                            
                            <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil" style="padding-right: 5px;margin-top: 10px;"></span>',array('action' => 'edit', $page['Managelist']['id']),array('confirm' => 'Are you sure you want to Edit this?','rel'=>'tooltip','title'=>'Edit','escape' => false));	?>


                             <!--  <?php echo $this->Html->link('<span class="glyphicon glyphicon-eye-open" style="padding-right: 5px;margin-top: 10px;"></span>',array('action'=>'view', $page['Faq']['id']),array('rel'=>'tooltip','title'=>'View','escape' => false));?> 
                              <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil" style="padding-right: 5px;margin-top: 10px;"></span>',array('action' => 'edit', $page['Faq']['id']),array('confirm' => 'Are you sure you want to Edit this Faq?','rel'=>'tooltip','title'=>'Edit','escape' => false));	?>	
                              <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span>',array('action' => 'delete', $page['Faq']['id']),array('confirm' => 'Are you sure you want to Delete this Faq?','rel'=>'tooltip','Delete'=>'View','escape' => false));	?>	 -->			
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
