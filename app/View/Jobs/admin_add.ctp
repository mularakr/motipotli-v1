<!--<link rel="stylesheet" href="<?=$basepath ?>adminfile/dist/css/AdminLTE.min.css">-->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add New Job
         <small></small>
      </h1>
      <ol class="breadcrumb">
         <li><a href=""><i class="fa fa-dashboard"></i><?php echo $this->Html->link('Home',array('controller'=>'jobs','action'=>'index'),array(
            'escape' => false));?> </a></li>
         <li class="active">Jobs</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <div class="box">
               <!-- Horizontal Form -->
               <div class="box box-info">
                  <?php  echo $this->Form->create('Job',array('url'=>array('controller'=>'jobs','action'=>'admin_add'),'method'=>'post','class'=>'form-horizontal','type'=>'file','autocomplete'=>'off','enctype'=>'multipart/form-data'));?>
                  <div class="box-body">
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">	
                           <span style="color:red;"><?php echo $this->Session->flash();?></span>	
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Job Title<span style="color:red">*</span></span></label>
                        <div class="col-sm-10">
                           <?php echo $this->Form->input('title',array('placeholder'=>'Job Title','type'=>'text','class'=>'form-control','pattern' => '.*[^ ].*','required'=>'required','label' => false));?>	
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Positions<span style="color:red">*</span></span></label>
                        <div class="col-sm-10">
                           <?php echo $this->Form->input('positions',array('placeholder'=>'Positions','type'=>'text','class'=>'form-control','pattern' => '.*[^ ].*','required'=>'required','label' => false));?>	
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Category</span></label>
                        <div class="col-sm-10">
                           <?php echo $this->Form->input('category_id',array('placeholder'=>'Category Id','type'=>'select','class'=>'form-control','pattern' => '.*[^ ].*','label' => false));?>	
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">User</span></label>
                        <div class="col-sm-10">
                           <?php echo $this->Form->input('user_id',array('placeholder'=>'User','type'=>'select','class'=>'form-control','label' => false));?>	
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Address 1</span></label>
                        <div class="col-sm-10">
                           <?php echo $this->Form->input('address1',array('placeholder'=>'Address 1','type'=>'text','class'=>'form-control','pattern' => '.*[^ ].*','label' => false));?>	
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Address 2</span></label>
                        <div class="col-sm-10">
                           <?php echo $this->Form->input('address2',array('placeholder'=>'Address 2','type'=>'text','class'=>'form-control','pattern' => '.*[^ ].*','label' => false));?>	
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Pincode</span></label>
                        <div class="col-sm-10">
                           <?php echo $this->Form->input('pincode',array('placeholder'=>'Pincode','type'=>'text','class'=>'form-control','pattern' => '.*[^ ].*','label' => false));?>	
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Description</span></label>
                        <div class="col-sm-10">
                           <?php echo $this->Form->input('description',array('placeholder'=>'Description','type'=>'text','class'=>'form-control','pattern' => '.*[^ ].*','label' => false));?>	
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">State</span></label>
                        <div class="col-sm-10">
                           <?php echo $this->Form->input('state_id',array('placeholder'=>'State','type'=>'select','class'=>'form-control','label' => false));?>	
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">City<span style="color:red">*</span></span></label>
                        <div class="col-sm-10">
                           <?php echo $this->Form->input('city_id',array('placeholder'=>'City','type'=>'select','class'=>'form-control','label' => false));?>	
                        </div>
                     </div>

					      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Start Date<span style="color:red">*</span></span></label>
                        <div class="col-sm-10">
                        <?php echo $this->Form->input('startdate',array('placeholder'=>'Start Date','type'=>'text','class'=>'form-control','id'=>'datetimepicker','required'=>'required','label' => false));?>                        
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">End Date<span style="color:red">*</span></span></label>
                        <div class="col-sm-10">
                        <?php echo $this->Form->input('enddate',array('placeholder'=>'End Date','type'=>'text','class'=>'form-control','id'=>'datetimepicker2','required'=>'required','label' => false));?>                        
                        </div>
                     </div> 
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Start Time<span style="color:red">*</span></span></label>
                        <div class="col-sm-10">
                        <?php echo $this->Form->input('starttime',array('placeholder'=>'Start Time','type'=>'text','required'=>'required','class'=>'form-control','id'=>'datetime1','label' => false));?>                        
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">End Time<span style="color:red">*</span></span></label>
                        <div class="col-sm-10">
                        <?php echo $this->Form->input('endtime',array('placeholder'=>'End Time','type'=>'text','required'=>'required','class'=>'form-control','id'=>'datetime2','label' => false));?>                        
                        </div>
                     </div>                     
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Job Cost<span style="color:red"></span></span></label>
                        <div class="col-sm-10">
                        <?php echo $this->Form->input('jobcost',array('placeholder'=>'Job Cost','type'=>'text','class'=>'form-control','label' => false));?>                        
                        </div>
                     </div>
                     <!--<div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">File Name<span style="color:red"></span></span></label>
                        <div class="col-sm-10">
                        <?php echo $this->Form->input('filename',array('placeholder'=>'File Name','type'=>'text','class'=>'form-control','label' => false));?>                        
                        </div>
                     </div>-->
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Allow Bids<span style="color:red"></span></span></label>
                        <div class="col-sm-10">
                        <?php echo $this->Form->input('allowbids',array('placeholder'=>'Allow Bids','type'=>'text','class'=>'form-control','label' => false));?>                        
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Id Proof<span style="color:red"></span></span></label>
                        <div class="col-sm-10">
                        <?php echo $this->Form->input('Idproof',array('placeholder'=>'Id Proof','type'=>'text','class'=>'form-control','label' => false));?>                        
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Include<span style="color:red"></span></span></label>
                        <div class="col-sm-10">
                        <?php echo $this->Form->input('Include',array('placeholder'=>'Include','type'=>'text','class'=>'form-control','label' => false));?>                        
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Is Complete<span style="color:red"></span></span></label>
                        <div class="col-sm-10">
                        <?php echo $this->Form->input('Iscomplete',array('placeholder'=>'Is Complete','type'=>'text','class'=>'form-control','label' => false));?>                        
                        </div>
                     </div>
                     <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label"><span style="color:black">Image</span></label>
                        <div class="col-sm-10">
                           <div class="field_wrapper">                         
                               <input type="file" name="images[]" value="" required/></br>
                               <a href="javascript:void(0);" class="add_button" title="Add field"><img src="<?php echo $this->webroot; ?>img/add.png"/></a>                          
                           </div>                                             
                        </div>                     
                     </div>
                     <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label"><span style="color:black"></span></label>								 
                        <div class="col-sm-10">
                           <?php 
                              echo $this->Form->submit('Save',array('class'=>'btn block btn-success','div'=> false,'style' => 'float:left;margin-right: 10px'));
                              echo $this->Html->link('Back', array('admin'=>true,'controller'=>'jobs', 'action'=>'index'),array('class'=>'btn bg-navy'));
                              ?>
                        </div>
                     </div>
                  </div>
                  <?php echo $this->Form->end();?>
               </div>
            </div>
         </div>
      </div>
</div>
</section>
</div>

<!--datePiker-->
<script src="<?=$basepath ?>adminfile/plugins/datepicker/bootstrap-datepicker.js"></script>
<!--DateTimePiker-->
<script src="<?=$basepath ?>adminfile/plugins/datetimepicker/moment-with-locales.js"></script>
<script src="<?=$basepath ?>adminfile/plugins/datetimepicker/bootstrap-datetimepicker.js"></script>

<!-- /.content-wrapper -->
<script type="text/javascript">
var dateToday = new Date();
     var timeDiff;
     $('#datetimepicker').datetimepicker({
         locale: 'en',
         // minDate: dateToday,    
         minDate: new Date(),          
         format: 'YYYY/MM/DD',               
         /*var date = $(this).datepicker("getDate");
         date.setDate(date.getDate() + 3);
         $("#datetimepicker2").datepicker("setDate", date);*/            
         minDate : moment(),           
             
     });
    $('#datetimepicker2').datetimepicker({
         locale: 'en',
         format: 'YYYY/MM/DD',
             daysOfWeekDisabled: [],               
             //minDate : moment(),
         useCurrent: false //Important! See issue #1075
    });
    $("#datetimepicker").on("dp.change", function (e) {
         if (timeDiff) {
        $('#datetimepicker2').data("DateTimePicker").date(e.date.add(timeDiff, 's'));    
        $('#datetimepicker2').data("DateTimePicker").minDate(false);
    } else $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker2").on("dp.change", function (e) {    
        var CurrStartDate = new Date($('#datetimepicker').data("DateTimePicker").date());
        var CurrEndDate = new Date($('#datetimepicker2').data("DateTimePicker").date());
        if (CurrEndDate) {
            timeDiff = (CurrEndDate - CurrStartDate) / 1000;
        }
        $('#datetimepicker').data("DateTimePicker").maxDate(e.date);
    });	
   $('#datetime1').datetimepicker({
     format: 'LT',  
     //defaultTime:dateToday.getTime(),   
   });
    $('#datetime2').datetimepicker({
     format: 'LT'
   }); 
  /* $.noConflict();
   $(document).ready(function() 
   {	
   
   		
   });    */
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    var maxField = 5; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><input type="file" name="images[]" value=""/></br><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="<?php echo $this->webroot; ?>img/remove.png"/></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>
