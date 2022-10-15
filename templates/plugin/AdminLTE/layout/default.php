<?php use Cake\Core\Configure; ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?= $this->Html->meta('favicon.ico', 'img/cosmic-logo.png', ['type' => 'icon']) ?>
  <title><?= 'SiteX | ' . $this->fetch('title'); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <?php echo $this->Html->css('AdminLTE./bower_components/bootstrap/dist/css/bootstrap.min'); ?>
  <!-- Font Awesome -->
  <?php echo $this->Html->css('AdminLTE./bower_components/font-awesome/css/font-awesome.min'); ?>
  <!-- Ionicons -->
  <?php echo $this->Html->css('AdminLTE./bower_components/Ionicons/css/ionicons.min'); ?>
  <!-- Theme style -->
  <?php echo $this->Html->css('AdminLTE.AdminLTE.min'); ?>
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <?php echo $this->Html->css('AdminLTE.skins/skin-'. Configure::read('Theme.skin') .'.min'); ?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- jQuery 3 -->
    <?php echo $this->Html->script('AdminLTE./bower_components/jquery/dist/jquery.min'); ?>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <?php echo $this->fetch('css'); ?>

</head>
<body class="hold-transition skin-<?php echo Configure::read('Theme.skin'); ?> sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo $this->Url->build('/'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><?php echo 'SX'?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?php echo 'SiteX'?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <?php echo $this->element('nav-top'); ?>
  </header>

  <?php echo $this->element('aside-main-sidebar'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <ol class="breadcrumb" style="margin-bottom:0px">
      <li><a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index']) ?>">SiteX</a></li>
      <?php
      $action = $this->request->getParam('action');
      $controller = $this->request->getParam('controller');
      $projectQuery = $this->request->getQuery('project');
      $userQuery = $this->request->getQuery('user');
      $companyQuery = $this->request->getQuery('company');

      if($controller == 'Inductions' && $action == 'add'){
          echo '<li><a href="'.$this->Url->build(['controller' => 'Projects', 'action' => 'index']).'">My Projects</a></li>';
          $action = 'Assign Workers';
      } elseif ($action == 'generateqr'){
          echo '<li><a href="'.$this->Url->build(['controller' => 'Projects', 'action' => 'index']).'">My Projects</a></li>';
          $action = 'Generate QR Codes';
      } elseif ($controller == 'Users' && $action == 'view'){
          $action = 'My Account';
      } elseif ($controller == 'Users' && $action == 'edit'){
          $action = 'Edit Account Details';
      } elseif ($controller == 'Projects' && $action == 'index'){
          $action = 'My Projects';
      } elseif ($controller == 'Projects' && $action == 'edit'){
          echo '<li><a href="'.$this->Url->build(['controller' => 'Projects', 'action' => 'index']).'">My Projects</a></li>';
          $action = 'Edit Project Details';
      } elseif ($action == 'pending'){
          $action = 'Pending Documents';
      } elseif ($action == 'review'){
          echo '<li><a href="'.$this->Url->build(['controller' => 'Signatures', 'action' => 'pending']).'">Pending Documents</a></li>';
          $action = 'Review';
      } elseif ($controller == 'Checkins' && $action == 'index'){
          echo '<li><a href="'.$this->Url->build(['controller' => 'Projects', 'action' => 'index']).'">My Projects</a></li>';
          $action = 'List Checkins';
      } elseif ($controller == 'Documents' && $action == 'add' && $projectQuery){
          echo '<li><a href="'.$this->Url->build(['controller' => 'Projects', 'action' => 'index']).'">My Projects</a></li>';
          $action = 'Add Induction Documents';
      } elseif ($controller == 'Documents' && $action == 'add' && $userQuery){
          echo '<li><a href="'.$this->Url->build(['controller' => 'Projects', 'action' => 'index']).'">My Account</a></li>';
          $action = 'Add Induction Documents';
      } elseif ($controller == 'Documents' && $action == 'add' && $companyQuery){
          echo '<li><a href="'.$this->Url->build(['controller' => 'Projects', 'action' => 'index']).'">My Company</a></li>';
          $action = 'Add Induction Documents';
      } elseif ($controller == 'Companies' && $action == 'view'){
          $action = 'Company Details';
      } elseif ($controller == 'Users' && $action == 'forgot'){
          $action = 'Reset Password';
      } elseif ($controller == 'Users' && $action == 'requestpassword'){
          $action = 'Request Password Reset';
      }

      echo '<li class="active">'.ucfirst($action).'</li>';

      ?>
    </ol>
    <?php echo $this->Flash->render(); ?>
    <?php echo $this->Flash->render('auth'); ?>
    <?php echo $this->fetch('content'); ?>

  </div>
  <!-- /.content-wrapper -->

  <?php echo $this->element('footer'); ?>

  <!-- Control Sidebar -->
  <?php echo $this->element('aside-control-sidebar'); ?>
  <!-- /.control-sidebar -->

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.7 -->
<?php echo $this->Html->script('AdminLTE./bower_components/bootstrap/dist/js/bootstrap.min'); ?>
<!-- AdminLTE App -->
<?php echo $this->Html->script('AdminLTE.adminlte.min'); ?>
<!-- Slimscroll -->
<?php echo $this->Html->script('AdminLTE./bower_components/jquery-slimscroll/jquery.slimscroll.min'); ?>
<!-- FastClick -->
<?php echo $this->Html->script('AdminLTE./bower_components/fastclick/lib/fastclick'); ?>

<?php echo $this->fetch('script'); ?>

<?php echo $this->fetch('scriptBottom'); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $(".navbar .menu").slimscroll({
            height: "200px",
            alwaysVisible: false,
            size: "3px"
        }).css("width", "100%");

        var a = $('a[href="<?php echo $this->Url->build() ?>"]');
        if (!a.parent().hasClass('treeview') && !a.parent().parent().hasClass('pagination')) {
            a.parent().addClass('active').parents('.treeview').addClass('active');
        }

    });
</script>

</body>
</html>
