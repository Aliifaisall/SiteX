<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Induction[]|\Cake\Collection\CollectionInterface $workers
 * @var $project
 * @var $search_words
 * @var $type
 */
$currentUser = $this->request->getAttribute('identity');
?>
<style>
    .column {
        float: left;
        width: 50%;
    }
    .vertical-center {
        margin: 0;
        position: absolute;
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
    }
</style>
<div class="users index content">
    <h3><?= __('Staff on Project: '.$project->name) ?></h3>
    <br/>
    <?= $this ->Form->create(null, ['type' => 'get'])?>
        <div class="column" style="max-width: 200px">
            <input type="text" name="key" class="form-control" id="key">
        </div>
        <div class="column" style="max-width: 90px; padding-left: 10px; padding-top: 6px">
            Search type:
        </div>
        <div class="column" style="max-width: 90px; padding-top: 6px">
            <select name="type" style="pt">
                <option value="1" <?php if ($type == 1){ echo 'selected="selected"'; } ?>>Name</option>
                <option value="0" <?php if ($type == 0){ echo 'selected="selected"'; } ?>>Company</option>
            </select>
        </div>
        <div class="column" style="max-width: 100px">
            <input type="submit" class="btn btn-block btn-primary" value="Search">
            <?= $this ->Form->end()?>
        </div>
    <br/>
    <br/>

    <?php if ($search_words != 0){
        echo 'Search results for: ' . $search_words . '. ';
        echo $this->Html->link(__('Clear search results'), ['action' => 'staff', $project->id]);
    } else {
        echo '<br/>';
    }?>
    <div class="table-responsive">
        <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
            <thead>
            <tr>
                    <th><?= $this->Paginator->sort('Induction ID') ?></th>
                    <th><?= $this->Paginator->sort('Employer') ?></th>
                    <th><?= $this->Paginator->sort('Name') ?></th>
                    <th><?= $this->Paginator->sort('Induction Date') ?></th>

                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($workers as $worker): ?>
                <tr>
                    <td><?= $this->Number->format($worker->id) ?></td>
                    <td><?= $this->Html->link(($worker->company_name), ['controller' => 'Companies', 'action' => 'view', $worker->company_id]) ?></td>
                    <td><?= $this->Html->link(($worker->fname.' '.$worker->lname), ['controller' => 'Users', 'action' => 'view', $worker->user_id]) ?></td>
                    <td>
                        <?php if($worker->inducted_date){
                            echo $worker->inducted_date;
                        } else {
                            echo 'Not Inducted';
                        } ?>
                    </td>
                    <td class="actions">
                        <?= $this->Form->postLink(__('Remove from Project'), ['controller' => 'Inductions', 'action' => 'delete', $worker->id],
                            ['confirm' => __('Are you sure you want to remove '.$worker->fname.' '.$worker->lname.' from this project?', $worker->id)]) ?>
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
