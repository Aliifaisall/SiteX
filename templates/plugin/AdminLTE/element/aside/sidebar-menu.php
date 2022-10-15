<?php
$currentUser = $this->request->getAttribute('identity');
$company_id = $this->request->getSession()->read('company_id');
$role = NULL;
if($currentUser){
    $role = $currentUser->role;
}

?>
<ul class="sidebar-menu" data-widget="tree">
    <?php
    if($role == NULL || $company_id == 0){
        echo '<li class="header">LOG IN TO SEE NAVIGATION</li>';
    } elseif($role == 'Builder'){ ?>
        <li class="header">BUILDER NAVIGATION</li>
        <li><a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index']) ?>"><i class="fa fa-book"></i> <span>My Projects</span></a></li>
        <li><a href="<?= $this->Url->build(['controller' => 'Companies', 'action' => 'view', $company_id]) ?>"><i class="fa fa-building-o"></i> <span>My Company</span></a></li>
        <li><a href="<?= $this->Url->build(['controller' => 'Companies', 'action' => 'pending', $currentUser->id]) ?>"><i class="fa fa-users"></i> <span>Pending Employees</span></a></li>
        <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $currentUser->id]) ?>"><i class="fa fa-user"></i> <span>My Account</span></a></li>
    <?php } elseif($role == 'Contractor'){ ?>
        <li class="header">CONTRACTOR NAVIGATION</li>
        <li><a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index']) ?>"><i class="fa fa-book"></i> <span>My Projects</span></a></li>
        <li><a href="<?= $this->Url->build(['controller' => 'Companies', 'action' => 'view', $company_id]) ?>"><i class="fa fa-building-o"></i> <span>My Company</span></a></li>
        <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $currentUser->id]) ?>"><i class="fa fa-user"></i> <span>My Account</span></a></li>
    <?php } elseif($role == 'On-site Worker'){?>
        <li class="header">ON-SITE WORKER NAVIGATION</li>
        <li><a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index']) ?>"><i class="fa fa-book"></i> <span>My Projects</span></a></li>
        <li><a href="<?= $this->Url->build(['controller' => 'Companies', 'action' => 'view', $company_id]) ?>"><i class="fa fa-building-o"></i> <span>My Company</span></a></li>
        <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $currentUser->id]) ?>"><i class="fa fa-user"></i> <span>My Account</span></a></li>
        <li><a href="<?= $this->Url->build(['controller' => 'Signatures', 'action' => 'pending']) ?>"><i class="fa fa-sticky-note-o"></i> <span>Pending Documents</span></a></li>
    <?php } ?>
</ul>
