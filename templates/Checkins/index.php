<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Checkin[]|\Cake\Collection\CollectionInterface $checkins
 * @var $currentDateTime
 * @var $maxHours
 * @var $project
 * @var $search_words
 * @var $type
 * @var $target_date_time
 */
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js" integrity="sha512-+UiyfI4KyV1uypmEqz9cOIJNwye+u+S58/hSwKEAeUMViTTqM9/L4lqu8UxJzhmzGpms8PzFJDzEqXL9niHyjA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
<div class="checkins index content">
    <h3><?= __('Checkins for site: '.$project->name) ?></h3>
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
    <div class="column" style="max-width: 50px; padding-left: 10px; padding-top: 6px">
        Date:
    </div>
    <div class="column" style="max-width: 110px ; padding-right: 10px">
        <input type="text" name="date" autocomplete="off" class="form-control" id="date"  value =<?= $target_date_time?>>
    </div>
    <div class="column" style="max-width: 100px">
        <input type="hidden" name="project" value=<?= $project->id?>>
        <input type="submit" class="btn btn-block btn-primary" value="Search">
        <?= $this ->Form->end()?>
    </div>
    <br/>
    <br/>

    <?php if ($search_words != 0){
        echo 'Search results for: ' . $search_words . '. ';
        echo $this->Html->link(__('Clear search results'), ['action' => 'index', '?' => ['project' => $project->id]]);
    } else {
        echo '<br/>';
    }?>
    <div class="table-responsive">
        <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('Name') ?></th>
                    <th><?= $this->Paginator->sort('Employer') ?></th>
                    <th><?= $this->Paginator->sort('checkin_datetime', 'Checkin Time') ?></th>
                    <th><?= $this->Paginator->sort('checkout_datetime', 'Checkout Time') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($checkins as $checkin): ?>
                <tr>
                    <td><?= $this->Html->link($checkin->fname.' '.$checkin->lname, ['controller' => 'Users', 'action' => 'view', $checkin->user_id]) ?></td>
                    <td><?= $this->Html->link($checkin->company_name, ['controller' => 'companies', 'action' => 'view', $checkin->company_id]) ?></td>
                    <td><?= h($checkin->checkin_datetime) ?></td>
                    <td><?php
                        $checkOutLimit = $checkin->checkin_datetime->add(new DateInterval("PT{$maxHours}H"));
                        if($checkin->checkout_datetime) {
                            echo h($checkin->checkout_datetime);
                        } elseif($checkOutLimit > $currentDateTime) {
                            echo 'Currently On Site';
                        } else {
                            echo 'Not Checked Out (Over 8hrs)';
                        } ?>
                    </td>
                </tr>
                <?php endforeach; if (count($checkins) == 0){
                    echo '<tr><td>This project has no checkins.</td></tr>';
                } ?>
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
<script>
    jQuery(function () {
        jQuery('#date').datetimepicker({
            onShow: function (ct) {
                this.setOptions({
                    startDate:'+1970/01/01',
                    format:'Y-m-d'
                })
            },
            timepicker: false
        });
    });
</script>

