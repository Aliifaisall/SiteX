<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Checkin $checkin
 * @var string[]|\Cake\Collection\CollectionInterface $projects
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row content">
    <div class="column-responsive column-80">
        <div class="checkins form">
            <?= $this->Form->create($checkin) ?>
            <fieldset>
                <legend><?= __('Click to sign out.') ?></legend>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
