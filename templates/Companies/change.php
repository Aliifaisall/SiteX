<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 * @var \Cake\Collection\CollectionInterface|string[] $projects
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var $companies
 */
$currentUser = $this->request->getAttribute('identity');
$role = $currentUser->role;
?>
<link rel="stylesheet" type="text/css" href="<?= $this->Url->build(DS.'css'.DS.'amsify.suggestags.css')?>">
<script type="text/javascript" src="<?= $this->Url->build(DS.'js'.DS.'jquery.amsify.suggestags.js')?>"></script>
<style>
    .column {
        float: left;
        width: 50%;
        max-width: 400px;
    }
</style>
<div>
    <div class="users form content">
        <h3>Register With a New Company</h3>
        <p>You are not currently assigned to any company.</p>
        <p>To continue using SiteX, please select a company.</p>
        <br/>
        <?= $this->fetch('content'); ?>
        <?= $this->Form->create() ?>
        <fieldset>
            <legend></legend>
            <div class="row" style="padding-left: 20px; padding-right: 20px; max-width: 440px">
                    <div class="input company_name pt-3"><label for="company_name">Employer (Please select one)</label><br/>
                        <input class="form-control w-25" style="min-width: 200px;" type="company_name" name="company_name" required="required" id="company_name" aria-required="true" maxlength="15"></div>
                    <div style="padding-top: 10px">If there are multiple companies with the same name, ask your employer which unique identifier [number] corresponds to them.</div>
            </div>
        </fieldset>
        <br/>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
        <br/>
    </div>
</div>

<?php echo $this->Html->script('AdminLTE./bower_components/bootstrap/dist/js/bootstrap.min'); ?>
<?php echo $this->Html->script('AdminLTE./plugins/iCheck/icheck.min'); ?>
<?php echo $this->fetch('script'); ?>
<?php echo $this->fetch('scriptBottom'); ?>

<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('input[name="company_name"]').amsifySuggestags({
            suggestions: [
                <?php foreach ($companies as $company){
                echo '\''.$company->name.' ['.$company->id.']\', ';
            } ?>
            ],
            tagLimit: 1
        });
    });
</script>
