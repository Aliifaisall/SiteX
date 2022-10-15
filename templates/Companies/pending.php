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
            <h3><?= __('Pending Employees') ?></h3>
            <?php if (!empty($employees)) : ?>
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
                        <?php
                        $empty = TRUE;
                        foreach ($employees as $users) : ?>
                            <?php $empty = FALSE; ?>
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
                                        echo $this->Html->Link(__('Accept'), ['controller' => 'Companies', 'action' => 'pending', $company->id,
                                            '?' => ['acceptUser' => $users->id]],
                                            ['confirm' => 'Are you sure you want to add '.$users->first_name.' '.$users->last_name.' to your company?']);
                                        echo '<br/>';
                                        echo $this->Html->Link(__('Reject'), ['controller' => 'Companies', 'action' => 'pending', $company->id,
                                            '?' => ['rejectUser' => $users->id]],
                                            ['confirm' => 'Are you sure you want to reject '.$users->first_name.' '.$users->last_name.' from your company?']);
                                    } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if($empty == TRUE){
                            echo '<tr><td>You have no pending staff approvals.</td></tr>';
                        } ?>
                    </table>
                </div>
            <?php endif; ?>
            <br/>
            <a class="btn btn-block btn-primary" style="width: 200px" href="<?= $this->Url->build(
                ['controller' => 'Companies', 'action' => 'staff', $company->id]) ?>">List Employees</a> <br/>
            <a class="btn btn-block btn-primary" style="width: 200px" href="<?= $this->Url->build(
                ['controller' => 'Companies', 'action' => 'view', $company->id]) ?>">Return to Company Details</a>
        </div>
    </div>
</div>
