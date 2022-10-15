<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 * @var $admin_id
 * @var $documents
 */
$currentUser = $this->request->getAttribute('identity');
?>
<div class="row content">
    <div class="column-responsive column-80">
        <div class="companies view">
            <h3><?= h($company->name) ?></h3>
            <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($company->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company Type') ?></th>
                    <td><?= h($company->company_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td>
                        <?= h($company->address_no).' '.h($company->address_street) ?><br/>
                        <?= h($company->address_suburb) ?><br/>
                        <?= h($company->address_state).' '.h($company->address_postcode) ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Contact Name') ?></th>
                    <td><?= h($company->contact_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Contact Email') ?></th>
                    <td><?= h($company->contact_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Contact Phone') ?></th>
                    <td><?= h($company->contact_phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('ABN') ?></th>
                    <td><?= h($company->abn) ?></td>
                </tr>
            </table>
            <?php if ($currentUser->id == $admin_id){ ?>
            <div class="related">
                <h4><?= __('Assigned Projects') ?></h4>
                <div class="table-responsive">
                    <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
                        <?php if (!empty($company->projects)){ ?>
                            <tr>
                                <th><?= __('Project Type') ?></th>
                                <th><?= __('Name') ?></th>
                                <th><?= __('Client Name') ?></th>
                                <th><?= __('Client Email') ?></th>
                                <th><?= __('Client Phone') ?></th>
                                <th><?= __('Start Date') ?></th>
                                <th><?= __('Status') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($company->projects as $projects) : ?>
                            <tr>
                                <td><?= h($projects->project_type) ?></td>
                                <td><?= h($projects->name) ?></td>
                                <td><?= h($projects->client_name) ?></td>
                                <td><?= h($projects->client_email) ?></td>
                                <td><?= h($projects->client_phone) ?></td>
                                <td><?= h($projects->start_date) ?></td>
                                <td><?= h($projects->status) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View Details'), ['controller' => 'Projects', 'action' => 'view', $projects->id]) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php } else {
                            echo '<td>This company does not have any assigned projects.</td>';
                        } ?>
                    </table>
                </div>
            </div>
            <?php } ?>
            <div class="related">
                <h4><?= __('Company Documents') ?></h4>
                <div class="table-responsive">
                    <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
                        <tr>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Issue Date') ?></th>
                            <th><?= __('Expiry Date') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($documents as $document) : ?>
                            <?php if (!$document->worker_accessible && $currentUser->role == 'On-site Worker'){
                                // Don't show it
                            } else { ?>
                            <tr>
                                <td><?= h($document->name) ?></td>
                                <td><?= h($document->issue_date) ?></td>
                                <td><?= h($document->expiry_date) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Documents', 'action' => 'view', $document->id]) ?>
                                </td>
                            </tr>
                            <?php } ?>
                        <?php endforeach; ?>
                        <?php if($documents->count() == 0){
                            echo '<tr><td>No company documents have been added.</td></tr>';
                        } ?>
                        <tr>
                            <td>
                        <?= $this->Html->link(__('Add Company Documents'), ['controller' => 'Documents', 'action' => 'add', '?' => ['company'=>$company->id]]) ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br/>
            <?php if ($currentUser->id == $admin_id){ ?>
                <a class="btn btn-block btn-primary" style="width: 200px" href="<?= $this->Url->build(
                ['controller' => 'Companies', 'action' => 'staff', $company->id]) ?>">List Employees</a> <br/>
                <a class="btn btn-block btn-primary" style="width: 200px" href="<?= $this->Url->build(
                    ['controller' => 'Companies', 'action' => 'pending', $company->id]) ?>">Pending Employees</a> <br/>
            <?php } ?>
        </div>
    </div>
</div>
