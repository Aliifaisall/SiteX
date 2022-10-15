<?php use Cake\Core\Configure;

/**
 * @var \App\View\AppView $this
 */

$this->loadHelper('Authentication.Identity');
$currentUser = $this->request->getAttribute('identity');
$session = $this->getRequest()->getSession();
$hasPendingDocuments = $session->read('hasPendingDocuments', FALSE);

?>
<nav class="navbar navbar-static-top">

  <?php if (isset($layout) && $layout == 'top'): ?>
  <div class="container">

    <div class="navbar-header">
      <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display']) ?>" class="navbar-brand"><?php echo Configure::read('Theme.logo.large') ?></a>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
        <i class="fa fa-bars"></i>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
        </div>
      </form>
    </div>
    <!-- /.navbar-collapse -->
  <?php else: ?>

    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>

  <?php endif; ?>



  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- User Account: style can be found in dropdown.less -->
        <?php if($currentUser){ ?>
            <!-- Notifications: style can be found in dropdown.less -->
            <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <?php
                    if($hasPendingDocuments){
                        echo '<span class="label label-warning">1</span>';
                    } else {
                        echo '<span class="label label-warning"></span>';
                    }
                    ?>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">Alerts</li>
                    <li>
                        <!-- inner menu: contains the actual data -->
                        <ul class="menu">
                            <?php if($hasPendingDocuments){ ?>
                                <li>
                                    <a href="<?= $this->Url->build(['controller' => 'signatures', 'action' => 'pending']) ?>">
                                        <i class="fa fa-warning text-yellow"></i> You have documents pending review.
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?= $this->Html->image('cosmic-logo-fill.png', array('class' => 'user-image', 'alt' => 'User Image')); ?>
                    <span class="hidden-xs"><?= h($currentUser->first_name.' '.$currentUser->last_name) ?></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <br/>
                        <?= $this->Html->image('cosmic-logo-fill.png', array('class' => 'user-image', 'alt' => 'User Image')); ?>
                        <p><?= h($currentUser->first_name.' '.$currentUser->last_name) ?></p>
                        <p><?= h($currentUser->role) ?></p>

                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="<?= $this->Url->build(['controller' => 'users', 'action' => 'view', $currentUser->id]) ?>" class="btn btn-default btn-flat">Account Details</a>
                        </div>
                        <div class="pull-right">
                            <a href="<?= $this->Url->build(['controller' => 'users', 'action' => 'logout']) ?>" class="btn btn-default btn-flat">Sign Out</a>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="dropdown notifications-menu">
                <a href="<?= $this->Url->build(['controller' => 'users', 'action' => 'logout']) ?>" class="dropdown-toggle">Log Out</a>
            </li>
        <?php } else { ?>
            <li class="dropdown notifications-menu">
                <a href="<?= $this->Url->build(['controller' => 'users', 'action' => 'login']) ?>" class="dropdown-toggle">Log In</a>
            </li>
        <?php } ?>

    </ul>
  </div>

  <?php if (isset($layout) && $layout == 'top'): ?>
  </div>
  <?php endif; ?>
</nav>
