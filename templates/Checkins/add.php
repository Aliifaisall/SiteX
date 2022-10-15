<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Checkin $checkin
 * @var \App\Model\Entity\Project $project
 * @var $checkout
 */
$currentUser = $this->request->getAttribute('identity');
$title = 'Check in to site: ';
$buttonLabel = 'Check In';
if ($checkout){
    $title = 'Check out of site: ';
    $buttonLabel = 'Check Out';
}
?>
<div class="row content">
    <div class="column-responsive column-80">
        <div class="checkins form">
            <?= $this->Form->create($checkin) ?>
            <fieldset>
                <legend><?= __($title.$project->name) ?></legend>
                <input type="hidden" name="Project" id="project" value="<?= $project->id ?>">
                <input type="hidden" name="User" id="user" value="<?= $currentUser->id ?>">
            </fieldset>
            <br/>
            <?= $this->Form->button(($buttonLabel), ['onclick' => 'this.form.submit(); this.disabled=true']) ?>
            <?= $this->Form->end() ?>
        </div>
        <br/>
    </div>
</div>
