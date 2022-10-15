<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 * @var string[]|\Cake\Collection\CollectionInterface $projects
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 *
 */
?>
<div class="row content">
    <div class="column-responsive column-80">
        <div class="companies edit content">
            <h3>
                <?= __('Actions') ?>
            </h3>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $company->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $company->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Companies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
    <div class="column-responsive column-80">
        <div class="companies form content">
            <?= $this->Form->create($company) ?>
            <fieldset>
                <legend><?= __('Edit Company') ?></legend>
                <table class="table table-bordered" style="background-color:ghostwhite; max-width:600px">
                <?php
                    echo $this->Form->control('name',['required'=> true, 'maxlength'=> 100]);
                    echo $this->Form->control('address_no',['required'=> true , 'maxlength'=>10]);
                    echo $this->Form->control('address_street',['required'=> true , 'maxlength'=>50]);
                    echo $this->Form->control('address_suburb',['required'=> true , 'maxlength'=>50]);
                    echo $this->Form->control('address_state',['required'=> true,'maxlength'=>50] );
                    echo $this->Form->control('address_postcode',['required'=> true,'maxlength'=>50]);
                    echo $this->Form->control('address_country',['required'=> true, 'maxlength'=>50]);
                    echo $this->Form->control('contact_name',['required'=> true, 'maxlength'=>50]);
                    echo $this->Form->control('contact_email',['required'=> true , 'maxlength'=>320]);
                    echo $this->Form->control('contact_phone',['required'=> true , 'maxlength'=>15]);
                    echo $this->Form->control('projects._ids', ['options' => $projects] );
                    echo $this->Form->control('users._ids', ['options' => $users]);
                ?>
                    </table>
                    </fieldset>
                        <?= $this->Form->button(__('Submit')) ?>
                        <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
