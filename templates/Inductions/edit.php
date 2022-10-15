<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Induction $induction
 * @var string[]|\Cake\Collection\CollectionInterface $projects
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js" integrity="sha512-+UiyfI4KyV1uypmEqz9cOIJNwye+u+S58/hSwKEAeUMViTTqM9/L4lqu8UxJzhmzGpms8PzFJDzEqXL9niHyjA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="row content">
    <div class="column-responsive column-80" style="max-width:800px">
        <div class="induction edit form">
            <h4 class="heading">
                <?= __('Actions') ?>
            </h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $induction->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $induction->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Inductions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </div>
    <div class="column-responsive column-80">
        <div class="inductions form content">
            <?= $this->Form->create($induction) ?>
            <fieldset>
                <legend><?= __('Edit Induction') ?></legend>
                <?php
                    echo $this->Form->control('project_id', ['options' => $projects]);
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('inducted_date', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

