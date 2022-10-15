<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 * @var $admin_id
 * @var $documents
 * @var $employees
 */
$currentUser = $this->request->getAttribute('identity');
?>

<div class="row content">
    <div class="column-responsive column-80">
        <div class="companies view">
            <h3><?= __($company->name . ' Employees') ?></h3>
            <?php if (!empty($company->users)) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
                        <tr>
                            <th><?= __('Role') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Email Address') ?></th>
                            <th><?= __('Phone (Mobile)') ?></th>
                            <th><?= __('Emergency Contact') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($employees as $users) : ?>
                            <tr>
                                <?php if ($users->role == 'Builder' || $users->role == 'Contractor'){$users->role = 'Administrator';} ?>
                                <td><?= h($users->role) ?></td>
                                <td><?= h($users->first_name.' '.$users->last_name) ?></td>
                                <td><?= h($users->email) ?></td>
                                <td><?= h($users->phone_mobile) ?></td>
                                <td><?= $users->emergency_name.' ('.$users->emergency_relationship.')</br>Phone: '.$users->emergency_phone ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                                    <br/>
                                    <?php if ($users->role != 'Administrator'){
                                        echo $this->Html->Link(__('Remove'), ['controller' => 'Companies', 'action' => 'staff', $company->id,
                                        '?' => ['deleteUser' => $users->id]],
                                        ['confirm' => 'Are you sure you want to remove '.$users->first_name.' '.$users->last_name.' from your company?']);
                                    } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
            <br/>
            <a class="btn btn-block btn-primary" style="width: 200px" href="<?= $this->Url->build(
                ['controller' => 'Companies', 'action' => 'pending', $company->id]) ?>">Pending Employees</a> <br/>
            <a class="btn btn-block btn-primary" style="width: 200px" href="<?= $this->Url->build(
                ['controller' => 'Companies', 'action' => 'view', $company->id]) ?>">Return to Company Details</a>
        </div>
    </div>
</div>
