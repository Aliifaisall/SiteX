<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var $employerAccess
 * @var $assignedProjects
 * @var $documents
 */
$currentUser = $this->request->getAttribute('identity');
?>
<div class="row content">
    <div class="column-responsive column-80">
        <div class="users view">
            <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
                 <h3>User Overview: <?= h($user->first_name.' '.$user->last_name)  ?></h3>
                <br/>
                <?php if ($currentUser->id == $user->id){ ?>
                    <a class="btn btn-block btn-primary" style="width: 200px"
                       href="<?= $this->Url->build(['action' => 'edit', $user->id]) ?>">Edit Profile
                    </a>
                <?php } ?>
                <br/>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($user->first_name.' '.$user->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= h($user->role) ?></td>
                </tr>
                <?php if ($currentUser->id == $user->id || $employerAccess){ ?>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td>
                        <?= h($user->address_no).' '.h($user->address_street) ?><br/>
                        <?= h($user->address_suburb) ?><br/>
                        <?= h($user->address_state).' '.h($user->address_postcode) ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mobile Phone') ?></th>
                    <td><?= h($user->phone_mobile) ?></td>
                </tr>
                <tr>
                    <th><?= __('Office Phone') ?></th>
                    <td><?= h($user->phone_office) ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <th><?= __('Emergency Contact') ?></th>
                    <td>
                        <?= h($user->emergency_name) ?> (<?= h($user->emergency_relationship) ?>)<br/>
                        Phone: <?= h($user->emergency_phone) ?><br/>
                    </td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Employer') ?></h4>
                <?php if (!empty($user->companies)) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
                        <tr>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Contact Name') ?></th>
                            <th><?= __('Contact Email') ?></th>
                            <th><?= __('Contact Phone') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->companies as $companies) : ?>
                        <tr>
                            <td><?= h($companies->name) ?></td>
                            <td><?= h($companies->contact_name) ?></td>
                            <td><?= h($companies->contact_email) ?></td>
                            <td><?= h($companies->contact_phone) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View Company Profile'), ['controller' => 'Companies', 'action' => 'view', $companies->id]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <?php if (($currentUser->id == $user->id || $employerAccess) && $currentUser->role == 'On-site Worker'){ ?>
            <div class="related">
                <h4><?= __('Assigned Worksites') ?></h4>
                <div class="table-responsive">
                    <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
                        <?php if (!empty($user->inductions)){ ?>
                            <tr>
                                <th><?= __('Induction ID') ?></th>
                                <th><?= __('Project') ?></th>
                                <th><?= __('Date Inducted') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($assignedProjects as $assignedProject) : ?>
                            <tr>
                                <td><?= h($assignedProject->id) ?></td>
                                <td><?= h($assignedProject->project_name) ?></td>
                                <td><?php if($assignedProject->inducted_date){
                                        echo $assignedProject->inducted_date;
                                    } else {
                                        echo 'Induction not complete.';
                                    }?>
                                </td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View Project Details'), ['controller' => 'Projects', 'action' => 'view', $assignedProject->project_id]) ?>
                                </td>
                            </tr>
                        <?php endforeach; } else { echo '<tr><td>User is not currently assigned to any projects.</td></tr>'; } ?>
                    </table>
                </div>
            </div>
                <div class="related">
                    <h4><?= __('Personal Documents') ?></h4>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
                            <tr>
                                <th><?= __('Name') ?></th>
                                <th><?= __('Issue Date') ?></th>
                                <th><?= __('Expiry Date') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($documents as $document) : ?>
                                <tr>
                                    <td><?= h($document->name) ?></td>
                                    <td><?= h($document->issue_date) ?></td>
                                    <td><?= h($document->expiry_date) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Documents', 'action' => 'view', $document->id]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if($documents->count() == 0){
                                echo '<tr><td>No personal documents have been added.</td></tr>';
                            } ?>
                            <tr>
                                <td>
                                    <?= $this->Html->link(__('Add Personal Documents'), ['controller' => 'Documents', 'action' => 'add']) ?>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
