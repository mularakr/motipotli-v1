<div class="container">
    <div class="row">
        <div style="display:flex;height:100vh;align-items:center;justify-content:center;">
            <div class="col-md-4 ">
			<div class="login-logo">     
                <img src="<?=$basepath ?>img/Logo_motipotli.png" height="50" width="170" class="user-image" alt="Logo Image">
            </div><!-- /.login-logo -->
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Log in</h3>
                    </div>
                    <div class="panel-body">
                        <?php if ($this->Session->check('Message.flash')) { ?>
                            <div class="alert alert-danger">
                                <?php echo $this->Session->flash(); ?>
                            </div>
                        <?php } ?>
                        <?php echo $this->Form->create('User',array('name'=>'login','id'=>'login-form','role'=>'form','autocomplete'=>'off','inputDefaults'=>array('label'=>false,'div'=>false))); ?>
                            <fieldset>
                                <div class="form-group">
                                    <?php echo $this->Form->input('email', array('placeholder'=>'Email','type'=>'text',"tabindex"=>"1",'autofocus'=>'autofocus','class'=>'form-control')); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $this->Form->input('password', array('placeholder'=>'Password',"tabindex"=>"2",'class'=>'form-control')); ?>
                                </div>                           
                                <?php echo $this->Form->button('Submit',array('type' => 'submit','class'=>'btn btn-lg btn-success btn-block')); ?>
                            </fieldset>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
