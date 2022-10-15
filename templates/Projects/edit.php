<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Project $project
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $documents
 */
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js" integrity="sha512-+UiyfI4KyV1uypmEqz9cOIJNwye+u+S58/hSwKEAeUMViTTqM9/L4lqu8UxJzhmzGpms8PzFJDzEqXL9niHyjA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="row content">
    <div class="column-responsive column-80" style="max-width:800px">
        <?= $this->Form->create($project) ?>
        <fieldset>
            <legend><?= __('Edit Project: '.$project->name) ?></legend>
            <?php
                echo $this->Form->control('client_name', ['required'=> true , 'maxlength'=>50]);
                echo $this->Form->control('client_email', ['required'=> true , 'maxlength'=>320]);
                echo $this->Form->control('client_phone', ['required'=> true , 'maxlength'=>12]);
                echo $this->Form->control('est_completion_date', ['type' => 'text', 'value' => '', 'autocomplete' => 'off', 'label' => 'Est. Completion Date (Currently '.$project->est_completion_date.')']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>

<script>
        jQuery(function () {
            jQuery('#est-completion-date').datetimepicker({
                onShow: function (ct) {
                    this.setOptions({
                        startDate:'+1970/01/01',
                        minDate:'+1970/01/01',
                        format:'Y-m-d'
                    })
                },
                timepicker: false
            });
        });
</script>
