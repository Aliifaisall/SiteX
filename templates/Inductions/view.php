<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Induction $induction
 */
?>
<div class="row content">
<div class="column-responsive column-80">
    <div class="induction details">
        <h3>
            <?= __('Actions') ?>
        </h3>
            <?= $this->Html->link(__('Edit Induction'), ['action' => 'edit', $induction->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Induction'), ['action' => 'delete', $induction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $induction->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Inductions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Induction'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    <div class="column-responsive column-80">
        <div class="inductions view content">
            <h3><?= h($induction->id) ?></h3>
            <table class="table table-bordered" style="background-color:ghostwhite; max-width: 600px">
                <tr>
                    <th><?= __('Project') ?></th>
                    <td><?= $induction->has('project') ? $this->Html->link($induction->project->name, ['controller' => 'Projects', 'action' => 'view', $induction->project->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $induction->has('user') ? $this->Html->link($induction->user->id, ['controller' => 'Users', 'action' => 'view', $induction->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($induction->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inducted Date') ?></th>
                    <td><?= h($induction->inducted_date) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</div>
</div>
