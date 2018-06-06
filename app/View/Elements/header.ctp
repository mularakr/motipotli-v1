<?php
  /**
  * @description Sidebar View
  */
  $controller = $this->params['controller'];
  $action = $this->action;

?>

<header class="main-header">
  <!-- Logo -->
  <a href="" class="logo"><span class="logo-lg"></span></a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">

    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span></a>

    <div class="navbar-custom-menu">

      <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?=$basepath ?>img/user_img.png" class="user-image" alt="User Image">
            <?php if ($this->Session->read('Auth.User')): ?>
            <span class="hidden-xs">
            <?php echo ucfirst($this->Session->read('Auth.User.name')); ?></span>    
            <?php endif; ?>
            </a>        
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">

                <img src="<?=$basepath ?>img/user_img.png" class="user-circle" alt="User Image">
                <p>
                <?php if ($this->Session->read('Auth.User')): ?>

                <?php if($this->Session->read('Auth.User.role')==''):?>

                <?php endif;?>  
                <?php echo ucfirst($this->Session->read('Auth.User.name')); ?>                 
                <?php endif; ?>
                </p>
              </li>
              <!-- Menu Body -->              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                <!--<a href="#" class="btn btn-default btn-flat">Change Password</a>-->
                <?php echo $this->Html->link('Change Password',array('admin'=>true,'controller'=>'users','action'=>'changePassword'),array('class'=>'btn btn-default btn-flat')); ?> 

                </div>
                <div class="pull-right">
                <?php echo $this->Html->link('Logout',array('controller'=>'users','action'=>'logout','admin'=>false),array('class'=>'btn btn-default btn-flat')); ?>  
                </div>
              </li>
            </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
        <!-- <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
        </li>
      </ul>
    </div>
  </nav>
</header>

<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel">
  <div class="pull-left image">
  <img src="<?=$basepath ?>img/user_img.png" class="user-image" alt="User Image">
  </div>
  <div class="pull-left info">
  <p><?php if ($this->Session->read('Auth.User')): ?>
  <span class="hidden-xs">

  <?php echo $this->Html->link(ucfirst($this->Session->read('Auth.User.name')),array('controller'=>'users', 'action'=>'index'),array(
  'escape' => false));?>
    
  </span>    
  <?php endif; ?></p>
  <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
  </div>
  </div>
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu">
  <li class="header">MAIN NAVIGATION</li>
  <li class="active treeview">      
  </li>
  <!-- <li class="treeview">-->
  <li class="treeview <?php if ($controller == 'users') { echo 'active'; } ?>">
      <a href="#">
        <i class="fa fa-user"></i>
        <span>Users</span><i class="fa fa-angle-left pull-right"></i>       
      </a>
      <ul class="treeview-menu">
      <li class="<?php if ($controller == 'users' && $action == 'index') { echo 'active'; } ?>">      
          <?php echo $this->Html->link('<i class="fa fa-circle-o"></i>User list',array('admin'=>true,'controller'=>'users','action'=>'index'),array(
          'escape' => false));?>            
          </li>
        <li class="<?php if ($controller == 'users' && $action == 'add') { echo 'active'; } ?>">
          <?php echo $this->Html->link('<i class="fa fa-circle-o"></i>Add New User',array('admin'=>true,'controller'=>'users','action'=>'add'),array(
          'escape' => false));?>            
        </li>
      </ul>
  </li>

  <li class="treeview <?php if ($controller == 'jobs') { echo 'active'; } ?>">
      <a href="#">
        <i class="fa fa-cog"></i>
        <span>Jobs</span><i class="fa fa-angle-left pull-right"></i>       
      </a>
      <ul class="treeview-menu">
      <li class="<?php if ($controller == 'jobs' && $action == 'index') { echo 'active'; } ?>">
        <?php echo $this->Html->link('<i class="fa fa-circle-o"></i>Job List',array('admin'=>true,'controller'=>'jobs','action'=>'index'),array(
        'escape' => false));?>            
        </li>
      <!-- <li class="<?php if ($controller == 'jobs' && $action == 'add') { echo 'active'; } ?>">
        <?php echo $this->Html->link('<i class="fa fa-circle-o"></i>Add New Job',array('admin'=>true,'controller'=>'jobs','action'=>'add'),array(
        'escape' => false));?>            
        </li> -->
      </ul>
  </li>

  <li class="treeview <?php if ($controller == 'categories') { echo 'active'; } ?>">
      <a href="#">
        <i class="fa fa-bars"></i>
        <span>Categories</span><i class="fa fa-angle-left pull-right"></i>       
      </a>
      <ul class="treeview-menu">
      <li class="<?php if ($controller == 'categories' && $action == 'index') { echo 'active'; } ?>">
        <?php echo $this->Html->link('<i class="fa fa-circle-o"></i>Categories List',array('admin'=>true,'controller'=>'categories','action'=>'index'),array(
        'escape' => false));?>            
      </li>     
      <li class="<?php if ($controller == 'categories' && $action == 'add') { echo 'active'; } ?>">
        <?php echo $this->Html->link('<i class="fa fa-circle-o"></i>Add New Categories',array('admin'=>true,'controller'=>'categories','action'=>'add'),array(
        'escape' => false));?>            
        </li>
      </ul>
  </li>

  <li class="treeview <?php if ($controller == 'paymentOptions') { echo 'active'; } ?>">
      <a href="#">
       <i class="fa fa-rupee"></i>
        <span>Payment Options</span><i class="fa fa-angle-left pull-right"></i>       
      </a>
      <ul class="treeview-menu">
      <li class="<?php if ($controller == 'paymentOptions' && $action == 'index') { echo 'active'; } ?>">
        <?php echo $this->Html->link('<i class="fa fa-circle-o"></i>Payment Options List',array('admin'=>true,'controller'=>'paymentOptions','action'=>'index'),array(
        'escape' => false));?>            
      </li>     
     <!--  <li class="<?php if ($controller == 'paymentOptions' && $action == 'add') { echo 'active'; } ?>">
        <?php echo $this->Html->link('<i class="fa fa-circle-o"></i>Add New Categories',array('admin'=>true,'controller'=>'paymentOptions','action'=>'add'),array(
        'escape' => false));?>            
        </li> -->
      </ul>
  </li> 

   <li class="treeview <?php if ($controller == 'manageCities') { echo 'active'; } ?>">
      <a href="#">
        <i class="fa fa-building-o"></i>
        <span>Manage State/Cities</span><i class="fa fa-angle-left pull-right"></i>       
      </a>
      <ul class="treeview-menu">
      <li class="<?php if ($controller == 'manageCities' && $action == 'index') { echo 'active'; } ?>">
        <?php echo $this->Html->link('<i class="fa fa-circle-o"></i>Cities List',array('admin'=>true,'controller'=>'manageCities','action'=>'index'),array(
        'escape' => false));?>            
      </li>           
      </ul>
  </li> 

  <li class="treeview <?php if ($controller == 'faqs') { echo 'active'; } ?>">
      <a href="#">
        <i class="fa fa-question"></i>
        <span>Faqs</span><i class="fa fa-angle-left pull-right"></i>       
      </a>
      <ul class="treeview-menu">
      <li class="<?php if ($controller == 'faqs' && $action == 'index') { echo 'active'; } ?>">      
          <?php echo $this->Html->link('<i class="fa fa-circle-o"></i>Faqs list',array('admin'=>true,'controller'=>'faqs','action'=>'index'),array(
          'escape' => false));?>            
      </li>

        <li class="<?php if ($controller == 'faqs' && $action == 'add') { echo 'active'; } ?>">
          <?php echo $this->Html->link('<i class="fa fa-circle-o"></i>Add Faq',array('admin'=>true,'controller'=>'faqs','action'=>'add'),array(
          'escape' => false));?>            
        </li>

      </ul>
  </li>
<!--Manage Content-->
  <li class="<?php if ($controller == 'managelists' && $action == 'list') { echo 'active'; } ?>">
          <?php echo $this->Html->link('<i class="fa fa-book"></i>Manage Content',array('admin'=>true,'controller'=>'managelists','action'=>'list'),array(
          'escape' => false));?>            
  </li>

 <li class="<?php if ($controller == 'paymentHistories' && $action == 'index') { echo 'active'; } ?>">
        <?php echo $this->Html->link('<i class="fa fa-money"></i>Payment Management',array('admin'=>true,'controller'=>'paymentHistories','action'=>'index'),array(
        'escape' => false));?>            
</li>

<li class="<?php if ($controller == 'contactQueries' && $action == 'index') { echo 'active'; } ?>">
        <?php echo $this->Html->link('<i class="fa fa-envelope"></i>Query Management',array('admin'=>true,'controller'=>'contactQueries','action'=>'index'),array(
        'escape' => false));?>            
</li>



  </ul>
  </section>
  <!-- /.sidebar -->
</aside>
