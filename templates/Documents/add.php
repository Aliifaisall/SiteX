<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 * @var \Cake\Collection\CollectionInterface|string[] $projects
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */

$currentUser = $this->request->getAttribute('identity');
$documentRelation = "user"; //Tells whether the upload is for personal or project-specific induction document.
$id = $currentUser->id;
$type = "Other";
$heading = "Add Personal Document";
if ($this->request->getQuery('project')){
    $documentRelation = "project";
    $id = $this->request->getQuery('project');
    $type = "Induction";
    $heading = "Add Site Induction Document";
} elseif ($this->request->getQuery('company')){
    $documentRelation = "company";
    $id = $this->request->getQuery('company');
    $heading = "Add Document for your Company";
}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js" integrity="sha512-+UiyfI4KyV1uypmEqz9cOIJNwye+u+S58/hSwKEAeUMViTTqM9/L4lqu8UxJzhmzGpms8PzFJDzEqXL9niHyjA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="row content">
    <div class="column-responsive column-80" style="max-width:800px">
        <div class="documents form content">
            <?= $this->Form->create($document, ['type' => 'file']) ?>
            <fieldset>
                <legend><?= __($heading) ?></legend>
                <?php
                    echo $this->Form->control('name', ['required'=> true, 'maxlength'=>50]);
                    echo $this->Form->control('details', ['label' => 'Details', 'required'=> true, 'maxlength'=>12]);
                    echo $this->Form->control('document_no', ['label' => 'Document Number (i.e. receipt number, license number)', 'required'=> true , 'maxlength'=>50]);
                    echo $this->Form->control('issuer', ['required'=> true, 'maxlength'=>50]);
                    echo $this->Form->control('issue_date', ['type' => 'text', 'label' => 'Issue Date (If Applicable)', 'autocomplete' => 'off', 'empty' => true]);
                    echo $this->Form->control('expiry_date', ['type' => 'text', 'label' => 'Expiry Date (If Applicable)', 'autocomplete' => 'off', 'empty' => true]);
                    echo $this->Form->control('file_upload', ['label' => 'Upload Document (PDF)', 'type' => 'file', 'required'=> true, 'accept' => '.pdf']);
                    if ($documentRelation == 'project'){
                        echo '<input type="checkbox" id="requires_signature" name="requires_signature" value="y">
                            <label for="requires_signature">Requires Signature</label><br/>';
                        echo $this->Form->control('declaration_text', ['label' => 'Declaration Text', 'required'=> true, 'maxlength'=>500]);
                    }
                    if ($documentRelation == 'company'){
                        echo '<input type="checkbox" id="worker_accessible" name="worker_accessible" value="y" checked="true">
                                <label for="worker_accessible">Make this document visible to on-site workers?</label><br/><br/>';
                    }
                    echo $this->Form->hidden('document_type', ['value' => $type]);
                    echo $this->Form->hidden('document_relation', ['value' => $documentRelation]);
                    echo $this->Form->hidden('relation_id', ['value' => $id]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['onclick' => 'this.form.submit(); this.disabled=true']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script>
    jQuery(function () {
        jQuery('#issue-date').datetimepicker({
            onShow: function (ct) {
                this.setOptions({
                    maxDate: jQuery('#expiry-date').val() ? jQuery('#expiry-date').val() : false,
                    format:'Y-m-d'
                })
            },
            timepicker: false
        });
        jQuery('#expiry-date').datetimepicker({
            onShow: function (ct) {
                this.setOptions({
                    minDate: jQuery('#issue-date').val() ? jQuery('#issue-date').val() : false,
                    format:'Y-m-d'
                })
            },
            timepicker: false
        });
    });
</script>
