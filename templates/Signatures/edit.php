<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Signature $signature
 * @var string[]|\Cake\Collection\CollectionInterface $documents
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $signature->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $signature->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Signatures'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="signatures form content">
            <?= $this->Form->create($signature) ?>
            <fieldset>
                <legend><?= __('Edit Signature') ?></legend>
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
