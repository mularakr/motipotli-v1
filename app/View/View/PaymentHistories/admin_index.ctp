 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Payment Histories
         <small></small>
      </h1>
      <ol class="breadcrumb">
         <li><a href=""><i class="fa fa-dashboard"></i><?php echo $this->Html->link('Home',array('controller'=>'paymentHistories','action'=>'index'),array(
            'escape' => false));?> </a></li>
         <li class="active">Payment Histories</li>
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
                       <!--  <?php $paginator = $this->Paginator; ?> -->
                        <tr >
                           <th style="text-align:center">Sr.no</th>
                           <th style="text-align:center">Job Details</th>
                           <th style="text-align:center">Employee Details</th>
                           <!-- <th style="text-align:center">Employees accepted bid amount</th>
                           <th style="text-align:center">Employee Name</th>
                           <th style="text-align:center">Payment Amount </th>
                           <th style="text-align:center">Date</th> -->
                        </tr>
                     </thead>
                     <tbody>
                     <?php 
                     $cnt = 0;
                     if(!empty($mydetails)){
                        foreach($mydetails as $key => $page){
                           $cnt += 1;
                        
                     ?>
                        <tr>
                           <td style="text-align:center"><?php echo $cnt; ?></td>
                           <td > 
                            <?php echo '<b>Job Title:</b>'.$page['title'].',<i>'.$page['category'].'</i></br><b>'.$page['company_name'].'</b>,'.$page['employer_name'].'<br>'.$page['position'].' Positions'; ?>
                              <!-- jobtitle,category<br>employername,companyname<br>no of post -->
                           </td>
                           <td >
                               <?php echo '<b>Employee Name: </b>'.$page['employee_name'].'<br>'.$page['bid_amount'].' INR'.','.'Payment Status:<b>'.$page['payment_status'].'</b>,'.'Payment Date: '.$page['date'];?>
                           </td>                         
                        </tr>
                     <?php }} ?>            
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>