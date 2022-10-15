<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 * @var string[]|\Cake\Collection\CollectionInterface $projects
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $document->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $document->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Documents'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="documents form content">
            <?= $this->Form->create($document) ?>
            <fieldset>
                <legend><?= __('Edit Document') ?></legend>
                <?php
                    echo $this->Form->control('name' , ['required'=> true , 'maxlength'=>50]);
                    echo $this->Form->control('document_no', ['maxlength'=>50]);
                    echo $this->Form->control('document_type');
                    echo $this->Form->control('class');
                    echo $this->Form->control('issuer', ['maxlength'=>50]);
                    echo $this->Form->control('issue_date', ['empty' => true]);
                    echo $this->Form->control('expiry_date', ['empty' => true]);
                    echo $this->Form->control('filepath');
                    echo $this->Form->control('photo_front_filepath');
                    echo $this->Form->control('photo_back_filepath');
                    echo $this->Form->control('projects._ids', ['options' => $projects]);
                    echo $this->Form->control('users._ids', ['options' => $users]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
