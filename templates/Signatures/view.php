<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Signature $signature
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Signature'), ['action' => 'edit', $signature->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Signature'), ['action' => 'delete', $signature->id], ['confirm' => __('Are you sure you want to delete # {0}?', $signature->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Signatures'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Signature'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="signatures view content">
            <h3><?= h($signature->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Document') ?></th>
                    <td><?= $signature->has('document') ? $this->Html->link($signature->document->id, ['controller' => 'Documents', 'action' => 'view', $signature->document->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $signature->has('user') ? $this->Html->link($signature->user->id, ['controller' => 'Users', 'action' => 'view', $signature->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($signature->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Signed Datetime') ?></th>
                    <td><?= h($signature->signed_datetime) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
