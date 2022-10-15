<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $documents
 */
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js" integrity="sha512-+UiyfI4KyV1uypmEqz9cOIJNwye+u+S58/hSwKEAeUMViTTqM9/L4lqu8UxJzhmzGpms8PzFJDzEqXL9niHyjA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="row content">
    <div class="column-responsive column-80" style="background-color:ghostwhite; max-width:800px">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Edit Your Profile') ?></legend>
                <?php
                    echo $this->Form->control('address_no');
                    echo $this->Form->control('address_street');
                    echo $this->Form->control('address_suburb');
                    echo $this->Form->control('address_state');
                    echo $this->Form->control('address_postcode');
                    echo $this->Form->control('address_country', ['required'=> true , 'type' => 'select']);
                    echo $this->Form->control('phone_mobile', ['label' => 'Mobile Phone']);
                    echo $this->Form->control('phone_office', ['label' => 'Office Phone']);
                    echo $this->Form->control('emergency_name', ['label' => 'Emergency Contact Name']);
                    echo $this->Form->control('emergency_relationship', ['label' => 'Emergency Contact Relationship']);
                    echo $this->Form->control('emergency_phone', ['label' => 'Emergency Contact Phone']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Confirm')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script>
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
