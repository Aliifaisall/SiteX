<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company[]|\Cake\Collection\CollectionInterface $companies
 */
?>

<div class="companies index content">
    <?= $this->Html->link(__('New Company'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Companies') ?></h3>
    <div class="table-responsive">
        <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
            <thead class="thead-dark">
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_type') ?></th>
                    <th><?= $this->Paginator->sort('abn') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('address_no') ?></th>
                    <th><?= $this->Paginator->sort('address_street') ?></th>
                    <th><?= $this->Paginator->sort('address_suburb') ?></th>
                    <th><?= $this->Paginator->sort('address_state') ?></th>
                    <th><?= $this->Paginator->sort('address_postcode') ?></th>
                    <th><?= $this->Paginator->sort('address_country') ?></th>
                    <th><?= $this->Paginator->sort('contact_name') ?></th>
                    <th><?= $this->Paginator->sort('contact_email') ?></th>
                    <th><?= $this->Paginator->sort('contact_phone') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($companies as $company): ?>
                <tr>
                    <td><?= $this->Number->format($company->id) ?></td>
                    <td><?= h($company->company_type) ?></td>
                    <td><?= $this->Number->format($company->abn) ?></td>
                    <td><?= h($company->name) ?></td>
                    <td><?= h($company->address_no) ?></td>
                    <td><?= h($company->address_street) ?></td>
                    <td><?= h($company->address_suburb) ?></td>
                    <td><?= h($company->address_state) ?></td>
                    <td><?= h($company->address_postcode) ?></td>
                    <td><?= h($company->address_country) ?></td>
                    <td><?= h($company->contact_name) ?></td>
                    <td><?= h($company->contact_email) ?></td>
                    <td><?= h($company->contact_phone) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $company->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $company->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $company->id], ['confirm' => __('Are you sure you want to delete # {0}?', $company->id)]) ?>
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
