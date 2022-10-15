<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Checkin $checkin
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Checkin'), ['action' => 'edit', $checkin->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Checkin'), ['action' => 'delete', $checkin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $checkin->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Checkins'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Checkin'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="checkins view content">
            <h3><?= h($checkin->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Project') ?></th>
                    <td><?= $checkin->has('project') ? $this->Html->link($checkin->project->name, ['controller' => 'Projects', 'action' => 'view', $checkin->project->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $checkin->has('user') ? $this->Html->link($checkin->user->id, ['controller' => 'Users', 'action' => 'view', $checkin->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Checkin Datetime') ?></th>
                    <td><?= h($checkin->checkin_datetime) ?></td>
                </tr>
                <tr>
                    <th><?= __('Checkout Datetime') ?></th>
                    <td><?= h($checkin->checkout_datetime) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
