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
            <?= $this->Html->link(__('List Equipment'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="equipment form content">
            <?= $this->Form->create($equipment) ?>
            <fieldset>
                <legend><?= __('Add Equipment') ?></legend>
                <?php
                    echo $this->Form->control('equipment_type');
                    echo $this->Form->control('name');
                    echo $this->Form->control('is_licensed');
                    echo $this->Form->control('builder_auth');
                    echo $this->Form->control('hired_from_date', ['empty' => true]);
                    echo $this->Form->control('hired_until_date', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
