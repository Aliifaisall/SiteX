<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Equipment $equipment
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Equipment'), ['action' => 'edit', $equipment->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Equipment'), ['action' => 'delete', $equipment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipment->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Equipment'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Equipment'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="equipment view content">
            <h3><?= h($equipment->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Equipment Type') ?></th>
                    <td><?= h($equipment->equipment_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($equipment->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($equipment->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Builder Auth') ?></th>
                    <td><?= $this->Number->format($equipment->builder_auth) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hired From Date') ?></th>
                    <td><?= h($equipment->hired_from_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hired Until Date') ?></th>
                    <td><?= h($equipment->hired_until_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Licensed') ?></th>
                    <td><?= $equipment->is_licensed ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
