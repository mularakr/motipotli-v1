
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
       Contact Queries
         <small></small>
      </h1>
      <ol class="breadcrumb">
         <li><a href=""><i class="fa fa-dashboard"></i><?php echo $this->Html->link('Home',array('controller'=>'contactQueries','action'=>'index'),array(
            'escape' => false));?> </a></li>
         <li class="active">Contact Queries</li>
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
                           <th style="text-align:center">Sr.no</th>
                           <th style="text-align:center">Name</th>
                           <th style="text-align:center">E-mail</th>
                           <th style="text-align:center">Message</th>                          
                        </tr>
                     </thead>
                     <tbody>                    
                     <?php 
                           $cnt=($this->request->params['paging']['ContactQuery']['page']-1) * $this->request->params['paging']['ContactQuery']['limit'];
                           if(!empty($myQueryDetails)){
                           foreach($myQueryDetails as $value):
                           $cnt+=1;                           
                           ?>
                        <tr>
                           <td style="text-align:center"><?php echo $cnt; ?></td>
                           <td style="text-align:center"><?php echo $value['ContactQuery']['name'] ?></td>
                           <td style="text-align:center"><?php echo $value['ContactQuery']['email'] ?></td> 
                           <td style="text-align:center">
                           <abbr title="<?php echo $value['ContactQuery']['message'] ?>"><?php echo substr($value['ContactQuery']['message'],0,80) ?></abbr>
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