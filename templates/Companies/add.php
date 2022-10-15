<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 * @var \Cake\Collection\CollectionInterface|string[] $projects
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
$currentUser = $this->request->getAttribute('identity');
$role = $currentUser->role;
?>
<div class="row content">
    <div class="column-responsive column-80">
        <div class="companies form content">
            <?= $this->Form->create($company) ?>
            <fieldset>
                <legend><?= __('Add Your Company Details') ?></legend>
                <p>Please complete this form before continuing to use SiteX.</p>
                <table class="table table-bordered" style="background-color:ghostwhite;">
                    <div class="row" style="padding-left: 20px; padding-right: 20px; max-width: 440px">
                    <?php
                    echo $this->Form->hidden('company_type', ['value'=>$role]);
                    echo $this->Form->control('abn', ['label' => 'ABN (11 Characters Required)', 'required'=> true, 'minlength'=>11, 'maxlength'=>11]);
                    echo $this->Form->control('name',['required'=> true, 'maxlength'=> 100]);
                    echo $this->Form->control('address_no',['required'=> true, 'maxlength'=>10]);
                    echo $this->Form->control('address_street',['required'=> true, 'maxlength'=>50]);
                    echo $this->Form->control('address_suburb',['required'=> true, 'maxlength'=>50]);
                    echo $this->Form->control('address_state',['required'=> true,'maxlength'=>50] );
                    echo $this->Form->control('address_postcode',['required'=> true,'maxlength'=>10]);
                    echo $this->Form->control('address_country',['required'=> true, 'maxlength'=>50]);
                    echo $this->Form->control('contact_name',['required'=> true, 'maxlength'=>50]);
                    echo $this->Form->control('contact_email',['required'=> true, 'maxlength'=>320]);
                    echo $this->Form->control('contact_phone',['required'=> true, 'minlength'=>8, 'maxlength'=>12]);
                    ?>
                    </div>
                </table>
            </fieldset>
            <?= $this->Form->button(__('Add Company')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
