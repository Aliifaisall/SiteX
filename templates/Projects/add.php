<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Project $project
 * @var  $countries
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $documents
 */

use Cake\Http\Client;


?>




<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js" integrity="sha512-+UiyfI4KyV1uypmEqz9cOIJNwye+u+S58/hSwKEAeUMViTTqM9/L4lqu8UxJzhmzGpms8PzFJDzEqXL9niHyjA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="row content">
    <div class="column-responsive column-80" style="max-width:800px">
        <div class="projects form">
            <?= $this->Form->create($project);
            ?>
            <fieldset>
                <legend><?= __('Add New Project') ?></legend>
                <?php
                echo $this->Form->control('name', ['label' => 'Project Name']);
                //echo $this->Form->control('client_id', ['options' => $users, 'empty' => true]);
                echo $this->Form->control('client_name', ['required'=> true , 'maxlength'=>50]);
                echo $this->Form->control('client_email' , ['required'=> true , 'maxlength'=>320]);
                echo $this->Form->control('client_phone', ['required'=> true , 'maxlength'=>12]);
                echo $this->Form->control('address_no', ['required'=> true , 'maxlength'=>10]);
                echo $this->Form->control('address_street',['required'=> true , 'maxlength'=>50]);
                echo $this->Form->control('address_suburb', ['required'=> true , 'maxlength'=>50]);
                echo $this->Form->control('address_state', ['required'=> true , 'maxlength'=>50]);
                echo $this->Form->control('address_postcode' ,['required'=> true , 'maxlength'=>20]);
                echo $this->Form->control('address_country', ['required'=> true ,'type' => 'select']);
                echo $this->Form->control('start_date', ['type' => 'text']);
                echo $this->Form->control('est_completion_date', ['type' => 'text']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['onclick' => 'this.form.submit(); this.disabled=true']) ?>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script>
    jQuery(function () {
        jQuery('#start-date').datetimepicker({
            onShow: function (ct) {
                this.setOptions({
                    maxDate: jQuery('#est-completion-date').val() ? jQuery('#est-completion-date').val() : false,
                    format:'Y-m-d'
                })
            },
            timepicker: false
        });
        jQuery('#est-completion-date').datetimepicker({
            onShow: function (ct) {
                this.setOptions({
                    minDate: jQuery('#start-date').val() ? jQuery('#start-date').val() : false,
                    format:'Y-m-d'
                })
            },
            timepicker: false
        });
    });

    let country_select = $('select#address-country');
    $.getJSON("https://restcountries.com/v3.1/all", function( data ) {
        var items = [];
        $.each( data, function( key, val ) {
            items.push( {id: val.name.common, text: val.name.common} );
        });
        // country_select.append(items.join(""));
        $("select#address-country").select2({
            data: items
        });
    });
</script>
