<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Induction[]|\Cake\Collection\CollectionInterface $inductions
 */
?>
<div class="inductions index content">
    <?= $this->Html->link(__('New Induction'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Inductions') ?></h3>
    <div class="table-responsive">
        <table class="table table-bordered" style="background-color:ghostwhite; max-width: 600px">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('project_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('inducted_date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inductions as $induction): ?>
                <tr>
                    <td><?= $this->Number->format($induction->id) ?></td>
                    <td><?= $induction->has('project') ? $this->Html->link($induction->project->name, ['controller' => 'Projects', 'action' => 'view', $induction->project->id]) : '' ?></td>
                    <td><?= $induction->has('user') ? $this->Html->link($induction->user->id, ['controller' => 'Users', 'action' => 'view', $induction->user->id]) : '' ?></td>
                    <td><?= h($induction->inducted_date) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $induction->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $induction->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $induction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $induction->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
