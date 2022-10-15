<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentsUser[]|\Cake\Collection\CollectionInterface $signatures
 */
?>
<div class="documentsUsers index content">
    <h3><?= __('Pending Documents') ?></h3>
    <div class="table-responsive">
        <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
            <thead>
            <tr>
                <th>Project</th>
                <th>Name</th>
                <th>Issue Date</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($signatures as $signature): ?>
                <tr>
                    <td><?= $this->Html->link(($signature->project_name),
                    ['controller' => 'projects', 'action' => 'view', $signature->project_id]) ?></td>
                    <td><?= h($signature->name) ?></td>
                    <td><?= h($signature->issue_date) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Review'), ['controller' => 'documents', 'action' => 'review', $signature->document_id,
                            '?' => ['rid' => $signature->id]]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if(count($signatures) == 0){
                echo '<tr><td>You have no documents requiring review.</td></tr>';
            } ?>
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
