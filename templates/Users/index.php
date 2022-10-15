<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="users index content">
    <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('role') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?></th>
                    <th><?= $this->Paginator->sort('last_name') ?></th>
                    <th><?= $this->Paginator->sort('address_no') ?></th>
                    <th><?= $this->Paginator->sort('address_street') ?></th>
                    <th><?= $this->Paginator->sort('address_suburb') ?></th>
                    <th><?= $this->Paginator->sort('address_state') ?></th>
                    <th><?= $this->Paginator->sort('address_postcode') ?></th>
                    <th><?= $this->Paginator->sort('address_country') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('phone_mobile') ?></th>
                    <th><?= $this->Paginator->sort('phone_office') ?></th>
                    <th><?= $this->Paginator->sort('emergency_name') ?></th>
                    <th><?= $this->Paginator->sort('emergency_relationship') ?></th>
                    <th><?= $this->Paginator->sort('emergency_phone') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= h($user->role) ?></td>
                    <td><?= h($user->first_name) ?></td>
                    <td><?= h($user->last_name) ?></td>
                    <td><?= h($user->address_no) ?></td>
                    <td><?= h($user->address_street) ?></td>
                    <td><?= h($user->address_suburb) ?></td>
                    <td><?= h($user->address_state) ?></td>
                    <td><?= h($user->address_postcode) ?></td>
                    <td><?= h($user->address_country) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= h($user->phone_mobile) ?></td>
                    <td><?= h($user->phone_office) ?></td>
                    <td><?= h($user->emergency_name) ?></td>
                    <td><?= h($user->emergency_relationship) ?></td>
                    <td><?= h($user->emergency_phone) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
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
