<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         List of Jobs
         <small></small>
      </h1>
      <ol class="breadcrumb">
         <li><a href=""><i class="fa fa-dashboard"></i><?php echo $this->Html->link('Home',array('controller'=>'jobs','action'=>'index'),array(
            'escape' => false));?> </a></li>
         <li class="active">Jobs</li>
      </ol>
       <?php  echo $this->Form->create('Job',array('url'=>array('controller'=>'jobs','action'=>'admin_index'),'method'=>'get','class'=>'form-horizontal','autocomplete'=>'off'));?>              
               <div class="SearchBar">
                     <?php echo $this->Form->input('search',array('placeholder'=>'Search job','type'=>'text','class'=>'form-control','pattern' => '.*[^ ].*','label' => false,'style' => 'float:left;'));?>
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
               <div class="box-body">
                  <table id="example2" class="table table-bordered ">
                     <thead>
                        <span style="align=center;color:red" ><?php echo $this->Session->flash();?></span>
                        <?php $paginator = $this->Paginator; ?>
                        <tr >
                           <th style="text-align:center">Sr.No</th>
                           <th style="text-align:center"><?php echo $paginator->sort('title', 'Title')?></th>
                           <th style="text-align:center">Positions</th>
                           <th style="text-align:center">Start Date</th>
                           <th style="text-align:center">End Date</th>
                           <th style="text-align:center">Status</th>
                           <th style="text-align:center">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                           $cnt=($this->request->params['paging']['Job']['page']-1) * $this->request->params['paging']['Job']['limit'];
                           if(!empty($jobs)){
                           foreach($jobs as $page):
                           $cnt+=1;
                           ?>
                        <tr>
                           <td style="text-align:center"><?php echo $cnt ?>&nbsp;</td>
                           <td ><?php echo h($page['Job']['title']); ?>&nbsp;</td>
                           <td ><?php echo h($page['Job']['positions']); ?>&nbsp;</td>
                           <td ><?php echo h($page['Job']['startdate']); ?>&nbsp;</td>
                           <td ><?php echo h($page['Job']['enddate']); ?>&nbsp;</td>
                           <td>
                              <?php $options = array('0'=>'Approved','1' => 'Disapproved');
                                 echo $this->Form->select('status', $options, array('empty'=>false, 'name'=>'data[Job][status]', 'default'=>$page['Job']['status'], 'class'=>'form-control ddStatus', 'data-id'=>$page['Job']['id'],'data-cnt'=>'jobs'));
                                 ?>
                           </td>
                           <td class="actions" align="center" >
                              <?php echo $this->Html->link('<span class="glyphicon glyphicon-eye-open" style="padding-right: 5px;margin-top: 10px;"></span>',array('action'=>'view', $page['Job']['id']),array('rel'=>'tooltip','title'=>'View','escape' => false));?> 

                              <?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil" style="padding-right: 5px;margin-top: 10px;"></span>',array('action' => 'edit', $page['Job']['id']),array('confirm' => 'Are you sure you want to Edit this Job?','rel'=>'tooltip','title'=>'Edit','escape' => false));	?>	
                              
                              <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span>',array('action' => 'delete', $page['Job']['id']),array('confirm' => 'Are you sure you want to Delete this Job?','rel'=>'tooltip','Delete'=>'View','escape' => false));	?>
                           </td>
                        </tr>
                        <?php endforeach; }else{
                           ?>
                        <tr>
                           <td style="text-align:center;color:red" colspan="7">no record found</td>
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
   $(document).ready(function() 
   {});
    
</script>

<style type="text/css">
   .SearchBar,
   .SearchBtn{
      float: left;
   }
</style>