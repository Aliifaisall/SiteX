<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Signature[]|\Cake\Collection\CollectionInterface $signatures
 */
?>
<div class="signatures index content">
    <?= $this->Html->link(__('New Signature'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Signatures') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('document_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('signed_datetime') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($signatures as $signature): ?>
                <tr>
                    <td><?= $this->Number->format($signature->id) ?></td>
                    <td><?= $signature->has('document') ? $this->Html->link($signature->document->id, ['controller' => 'Documents', 'action' => 'view', $signature->document->id]) : '' ?></td>
                    <td><?= $signature->has('user') ? $this->Html->link($signature->user->id, ['controller' => 'Users', 'action' => 'view', $signature->user->id]) : '' ?></td>
                    <td><?= h($signature->signed_datetime) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $signature->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $signature->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $signature->id], ['confirm' => __('Are you sure you want to delete # {0}?', $signature->id)]) ?>
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
