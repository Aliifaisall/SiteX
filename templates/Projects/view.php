<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Project $project
 * @var $documents
 * @var $checkins
 * @var $workers
 * @var $currentDateTime
 * @var $maxHours
 */
$currentUser = $this->request->getAttribute('identity');
?>
<div class="row content">
    <div class="column-responsive column-80">
        <div class="projects view">
            <h3><?= h($project->name) ?></h3>
            <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
                <tr>
                    <th><?= __('Project Name') ?></th>
                    <td><?= h($project->name) ?></td>
                </tr>
                <?php if ($project->has('user')){ ?>
                    <tr>
                        <th><?= __('Builder') ?></th>
                        <td><?= $project->has('user') ? $this->Html->link($project->user->first_name.' '.$project->user->last_name, ['controller' => 'Users', 'action' => 'view', $project->user->id]) : '' ?></td>
                    </tr> <?php } ?>
                <tr>
                    <th><?= __('Site Address') ?></th>
                    <td>
                        <?= h($project->address_no .' '. $project->address_street) ?><br/>
                        <?= h($project->address_suburb) ?><br/>
                        <?= h($project->address_state .' '. $project->address_postcode) ?>
                    </td>
                </tr>
                <?php if ($currentUser->id == $project->user->id){ ?>
                    <tr>
                        <th><?= __('Client Details') ?></th>
                        <td>
                            <?= h($project->client_name) ?><br/>
                            <?= h($project->client_email) ?><br/>
                            <?= h($project->client_phone) ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Start Date') ?></th>
                        <td><?= h($project->start_date) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Estimated Completion Date') ?></th>
                        <td><?= h($project->est_completion_date) ?></td>
                    </tr>
                    <tr>
                <?php } ?>
                    <th><?= __('Status') ?></th>
                    <td><?= h($project->status) ?></td>
                </tr>
                <?php if($project->status == 'Complete'){
                    echo '<tr>
                            <th>Completion Date</th>
                            <td><?='.h($project->completion_date).'</td>
                           </tr>';
                    } ?>
            </table>
            <div class="related">
                <h4><?= __('Assigned Companies') ?></h4>
                <?php if (!empty($project->companies)) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
                        <tr>
                            <th><?= __('Role') ?></th>
                            <th><?= __('Company Name') ?></th>
                            <th><?= __('Contact Name') ?></th>
                            <th><?= __('Contact Email') ?></th>
                            <th><?= __('Contact Phone') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($project->companies as $companies) : ?>
                        <tr>
                            <td><?= h($companies->company_type) ?></td>
                            <td><?= h($companies->name) ?></td>
                            <td><?= h($companies->contact_name) ?></td>
                            <td><?= h($companies->contact_email) ?></td>
                            <td><?= h($companies->contact_phone) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View Details'), ['controller' => 'Companies', 'action' => 'view', $companies->id]) ?>
                                <br/>
                                <?php if ($currentUser->id = $project->builder_id && $companies->company_type == 'Contractor'){
                                    echo $this->Html->link(__('Remove'), ['controller' => 'Projects', 'action' => 'removeContractor', $project->id,
                                        '?' => ['company' => $companies->id]], ['confirm' => 'Are you sure you want to remove '.$companies->name.' and all '.$companies->name.' workers from this project?']);
                                } ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Induction Documents') ?></h4>
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
                            echo '<tr><td>No induction documents have been added.</td></tr>';
                        } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
