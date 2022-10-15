<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Signature $signature
 * @var \Cake\Collection\CollectionInterface|string[] $documents
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Signatures'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="signatures form content">
            <?= $this->Form->create($signature) ?>
            <fieldset>
                <legend><?= __('Add Signature') ?></legend>
                <?php
                    echo $this->Form->control('document_id', ['options' => $documents]);
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('signed_datetime', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
