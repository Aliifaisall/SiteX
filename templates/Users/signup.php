<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company[]|\Cake\Collection\CollectionInterface $companies
 * @var \App\Model\Entity\User $user
 */
use Cake\Core\Configure;

$role = $this->request->getQuery('role');

if (!$role) { ?>

<body class="hold-transition register-page">
<div class="register-body content">
    <h3>Please select the type of account to create:</h3>
    <p>If you plan to use SiteX as the owner or administrator of a business, please choose your business type:</p>
    <a class="btn btn-block btn-primary" style="width: 200px" href="?role=Builder">Builder</a><br/>
    <a class="btn btn-block btn-primary" style="width: 200px" href="?role=Contractor">Contractor</a>
    <br/><br/>
    <p>If you are an employee or subcontractor, choose this option:</p>
    <a class="btn btn-block btn-primary" style="width: 200px" href="?role=Employee">Employee / Subcontractor</a>
</div>

<?php } else { ?>

<link rel="stylesheet" type="text/css" href="<?= $this->Url->build(DS.'css'.DS.'amsify.suggestags.css')?>">
<script type="text/javascript" src="<?= $this->Url->build(DS.'js'.DS.'jquery.amsify.suggestags.js')?>"></script>
<style>
    .column {
        float: left;
        width: 50%;
        max-width: 400px;
    }
</style>
<div>
    <div class="users form content">
        <h3>Register a New <?= $role ?> Account</h3>
        <p><strong>All fields are required.</strong></p>
        <?= $this->fetch('content'); ?>
        <?= $this->Form->create($user) ?>
         <fieldset>
                <legend></legend>
                <div class="row" style="padding-left: 20px; padding-right: 20px; max-width: 440px">
                    <input type="hidden" name="role" id="role" value="<?= $role ?>">
                    <?php

                    echo $this->Form->control('email', ['label' => 'Email Address', 'required'=> true, 'maxlength'=>320]);
                    echo $this->Form->control('password', ['label' => 'Password (Minimum 8 characters)', 'required'=> true, 'minlength'=>8]);
                    echo $this->Form->control('first_name', ['required'=> true]);
                    echo $this->Form->control('last_name', ['required'=> true]);
                    echo $this->Form->control('phone_mobile', ['label' => 'Mobile Phone Number', 'required'=> true, 'minlength'=>8, 'maxlength'=>12]);
                    echo $this->Form->control('phone_office', ['label' => 'Office Phone Number', 'required'=> true, 'minlength'=>8, 'maxlength'=>12]);
                    echo $this->Form->control('address_no', ['label' => 'Address Number', 'required'=> true]);
                    echo $this->Form->control('address_street', ['required'=> true]);
                    echo $this->Form->control('address_suburb', ['required'=> true]);
                    echo $this->Form->control('address_state', ['required'=> true]);
                    echo $this->Form->control('address_postcode', ['required'=> true]);
                    echo $this->Form->control('address_country', ['required'=> true]);
                    echo $this->Form->control('emergency_name', ['label' => 'Emergency Contact Name', 'required'=> true]);
                    echo $this->Form->control('emergency_relationship', ['label' => 'Emergency Contact Relationship', 'required'=> true]);
                    echo $this->Form->control('emergency_phone', ['label' => 'Emergency Contact Phone', 'required'=> true, 'minlength'=>8, 'maxlength'=>12]);
                    ?>
                    <?php if ($role == 'Employee'){?>
                        <div class="input company_name pt-3"><label for="company_name">Employer (Please select one)</label><br/>
                            <input class="form-control w-25" style="min-width: 200px;" type="company_name" name="company_name" required="required" id="company_name" aria-required="true" maxlength="15"></div>
                        <div style="padding-top: 10px">If there are multiple companies with the same name, ask your employer which unique identifier [number] corresponds to them.</div>
                    <?php } ?>
                </div>
            </fieldset>
            <br/>
            <?= $this->Form->button(__('Sign Up')) ?>
            <?= $this->Form->end() ?>
        <br/>
        <a href="<?= $this->Url->build(['action' => 'login']) ?>">Return to Login</a><br>
    </div>
</div>

<?php echo $this->Html->script('AdminLTE./bower_components/bootstrap/dist/js/bootstrap.min'); ?>
<?php echo $this->Html->script('AdminLTE./plugins/iCheck/icheck.min'); ?>
<?php echo $this->fetch('script'); ?>
<?php echo $this->fetch('scriptBottom'); ?>

<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
<?php if ($role == 'Employee'){ ?>
<script>
    $(document).ready(function(){
        $('input[name="company_name"]').amsifySuggestags({
            suggestions: [
                <?php foreach ($companies as $company){
                echo '\''.$company->name.' ['.$company->id.']\', ';
                } ?>
            ],
            tagLimit: 1
        });
    });
</script>
<?php } ?>
<?php } ?>
