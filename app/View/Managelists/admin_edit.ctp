<!-- Content Wrapper. Contains page content -->
<script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
<script src="<?=$basepath ?>adminfile/dist/js/ckfinder/ckfinder.js" type="text/javascript"></script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Edit Content
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
         <!-- Horizontal Form -->
        <div class="box box-info">
         <?php  echo $this->Form->create('Managelist',array('url'=>array('controller'=>'managelists','action'=>'admin_edit'),'method'=>'post','class'=>'form-horizontal','autocomplete'=>'off'));?>
          <div class="box-body">
            
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Title<span style="color:red">*</span></span></label>
            <div class="col-sm-10">
              <?php echo $this->Form->input('listitem',array('placeholder'=>'','type'=>'text','class'=>'form-control','required'=>'required','pattern' => '.*[^ ].*','label' => false));?>

              <?php echo $this->Form->input('id',array('placeholder'=>'','type'=>'hidden','class'=>'form-control','label' => false));?>
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label"><span style="color:black">Content<span style="color:red">*</span></span></label>
            <div class="col-sm-10">
            <?php
              if($this->request->data['Managelist']['type'] == 'contact'){
                   echo $this->Form->textarea('content', array('placeholder'=>'content','rows' => '10', 'cols' => '5', 'class'=>'form-control', 'id'=>'content', 'required'=>'required','label' => false));
                }else{
                  echo $this->Form->textarea('content', array('size' => '', 'class'=>'ckeditor form-control', 'required' => 'required', 'label'=>false, 'id'=>'content'));
                }
                ?>
            </div>
          </div>        
          <div class="form-group">
             <label for="inputPassword3" class="col-sm-2 control-label"><span style="color:black"></span></label>                
            <div class="col-sm-10">         
            <?php           
            echo $this->Form->submit('Save',array('class'=>'btn block btn-success','div'=> false,'style' => 'float:left;margin-right: 10px'));
            
             echo $this->Html->link('Back', array('admin'=>true,'controller'=>'managelists', 'action'=>'admin_list'),array('class'=>'btn bg-navy'));

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
  <!-- /.content-wrapper -->
  <script type="text/javascript">  
  $.noConflict();
  $(document).ready(function() 
  { 
  });
  </script>