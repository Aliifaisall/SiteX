<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Induction $induction
 * @var \App\Model\Entity\Project $project
 * @var \Cake\Collection\CollectionInterface|string[] $projects
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var $contractors
 */
$currentUser = $this->request->getAttribute('identity');
?>
<div class="row content">
    <div class="column-responsive column-80">
        <h3>Assign Staff to Project: <?= $project->name ?></h3>
        <div class="inductions form">
            <?= $this->Form->create($induction) ?>
            <fieldset>
                <legend></legend>
                <?php if($users->count() == 0){
                    echo 'There are no workers to assign to this project.';
                    $this->Form->end(); ?>
                    <br/><br/>
                <?php
                } else { ?>
                    <input type="hidden" name="Project" id="project" value="<?= $project->id ?>">

                    <select name="Worker" class="form-control" id="worker" style="max-width: 400px">
                        <?php
                        foreach ($users as $user){
                            echo '<option value="'.$user->id.'">'.$user->first_name.' '.$user->last_name.'</option>';
                        }
                        ?>
                    </select>
            </fieldset>
            <br/>
            <?= $this->Form->button(__('Assign Worker')) ?>
            <?= $this->Form->end() ?>
        <?php } ?>
        </div>
    </div>
    <?php if ($currentUser->id == $project->builder_id){ ?>
    <br/>
    <br/>
    <div class="column-responsive column-80">
        <div class="inductions form">
            <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('Assign Contracting Company') ?></legend>
                <?php if($contractors->count() == 0){
                    echo 'There are no contracting companies to assign to this project.';
                    $this->Form->end(); ?>
                    <br/><br/>
                    <?php
                } else { ?>
                <input type="hidden" name="Project" id="project" value="<?= $project->id ?>">

                <select name="Contractor" class="form-control" id="contractor" style="max-width: 400px">
                    <?php
                    foreach ($contractors as $contractor){
                        echo '<option value="'.$contractor->id.'">'.$contractor->name.'</option>';
                    }
                    ?>
                </select>
            </fieldset>
        <br/>
        <?= $this->Form->button(__('Assign Contractor')) ?>
        <?= $this->Form->end() ?>
        <?php } ?>
        </div>
    </div>
    <?php } ?>
    <br/>
    <br/>
    <a class="btn btn-block btn-primary" style="width: 300px" href="<?= $this->Url->build(
        ['controller' => 'Projects', 'action' => 'index']) ?>">Return to Projects Index</a>
</div>
