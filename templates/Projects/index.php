<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Project[]|\Cake\Collection\CollectionInterface $projects
 * @var $selected
 * @var $builder
 */
$currentUser = $this->request->getAttribute('identity');

?>
<div class="projects index content">
    <h3><?= __('My Projects') ?></h3><br/>
    <?php if($currentUser->role == 'Builder'){ ?>
        <a class="btn btn-block btn-primary" style="width: 200px" href="<?= $this->Url->build(
            ['controller' => 'Projects', 'action' => 'add']) ?>">Add New Project</a>
    <?php } ?>
    <br/>
    <form method="get" accept-charset="utf-8" action=
        <?= $this->Url->build(['controller' => 'projects', 'action' => 'index'])?>>
        <div class="row align-items-stretch">
            <div class="col-md-2">
                <label class="pb-1" for="sort_by">Filter by Status:</label>
                <select onchange="this.form.submit()" class="form-select" name="status" id="status">
                    <option  value="All" <?= $selected == 'All' ? 'selected' : '' ?>>All</option>
                    <option  value="Active" <?= $selected == 'Active' ? 'selected' : '' ?>>Active</option>
                    <option  value="Complete" <?= $selected == 'Complete' ? 'selected' : '' ?>>Complete</option>
                    <option  value="Cancelled" <?= $selected == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
        </div>
    </form>
    <br/>
    <div class="table-responsive">
        <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('project_type') ?></th>
                    <?php if($currentUser->role == 'Builder'){ echo '<th>Client</th>';} ?>
                    <?php if($currentUser->role != 'Builder'){ echo '<th>Builder</th>';} ?>
                    <th>Address</th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <?php if($currentUser->role == 'On-site Worker'){
                        echo '<th>Induction</th>';
                    }?>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project): ?>
                <tr onclick="window.location='<?= $this->Url->build(['action' => 'view', $project->id]) ?>';">
                    <td><?= h($project->name) ?></td>
                    <td><?= h($project->project_type) ?></td>
                    <?php if($currentUser->role == 'Builder'){ echo '<td>'.h($project->client_name).'</td>';} ?>
                    <?php
                    if($currentUser->role != 'Builder'){
                        echo '<td>'.$this->Html->link(($project->builder_fname.' '.$project->builder_lname),
                                ['controller' => 'Users', 'action' => 'view', $project->builder_id]).'</td>';
                    } ?>

                    <td><?= h($project->address_no.' '.$project->address_street) ?>
                        <br/>
                        <?= h($project->address_suburb) ?>
                        <br/>
                        <?= h($project->address_state.' '.$project->address_postcode) ?>
                    </td>
                    <td><?= h($project->start_date) ?></td>
                    <td><?= h($project->status) ?></td>
                    <?php if($currentUser->role == 'On-site Worker'){
                        if ($project->inducted_date){
                            echo '<td>Complete</td>';
                        } else {
                            echo '<td>Incomplete</td>';
                        }
                    }?>
                    <td class="actions">
                        <?php if($currentUser->role == 'Builder'){ ?>
                            <?= $this->Html->link(__('View Details'), ['action' => 'view', $project->id]) ?><br/>
                            <?= $this->Html->link(__('List Check-ins'), ['controller' => 'checkins', 'action' => 'index', '?' => ['project' => $project->id]]) ?><br/>
                            <?= $this->Html->link(__('List Staff'), ['controller' => 'Projects', 'action' => 'staff', $project->id]) ?><br/>
                            <?= $this->Html->link(__('Edit Details'), ['action' => 'edit', $project->id]) ?><br/>
                            <?= $this->Html->link(__('Generate QR Codes'), ['action' => 'generateqr', $project->id]) ?><br/>
                            <?= $this->Html->link(__('Assign Staff'), ['controller' => 'inductions', 'action' => 'add', '?' => ['project' => $project->id]]) ?><br/>
                            <?= $this->Html->link(__('Add Induction Documents'), ['controller' => 'documents', 'action' => 'add', '?' => ['project' => $project->id]]) ?><br/>
                        <?php } elseif($currentUser->role == 'Contractor'){ ?>
                            <?= $this->Html->link(__('View Details'), ['action' => 'view', $project->project_id]) ?><br/>
                            <?= $this->Html->link(__('List Staff'), ['controller' => 'Projects', 'action' => 'staff', $project->id]) ?><br/>
                            <?= $this->Html->link(__('Assign Staff'), ['controller' => 'inductions', 'action' => 'add', '?' => ['project' => $project->id]]) ?><br/>
                        <?php } elseif($currentUser->role == 'On-site Worker'){ ?>
                            <?= $this->Html->link(__('View Details'), ['action' => 'view', $project->project_id]) ?><br/>
                        <?php } ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(count($projects) == 0){
                    echo '<tr><td>You have no assigned projects.</td></tr>';
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
