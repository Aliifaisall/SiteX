<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */
$type = '';
$id =  '';
if($document -> related_project_id){
    $type = 'Induction';
    $id = $document -> related_project_id;
}
elseif($document -> related_company_id){
    $type = 'Company';
    $id = $document -> related_company_id;
}
elseif($document -> related_user_id){
    $type = 'Personal';
    $id = $document -> related_user_id;
}
?>
<div class="row content">
    <div class="column-responsive column-80">
        <div class="documents view content">
            <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
                <tr>
                    <th><?= __('Document') ?></th>
                    <td><?= h($document->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Document Type') ?></th>
                    <td><?= h($document->document_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Issue Date') ?></th>
                    <td><?= h($document->issue_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Expiry Date') ?></th>
                    <td><?= h($document->expiry_date) ?></td>
                </tr>
            </table>
            <div id ="content-desktop">
                <embed src="<?= $this->Url->build(DS.'uploads'.DS.$type.DS.$id.DS.$document->id.'.pdf') ?>" width="60%" height="1200px"/>
            </div>
            <a class="btn btn-block btn-primary" style="width: 200px" href="<?= $this->Url->build(
                ['controller' => 'Documents', 'action' => 'download', $document->id]) ?>">Download PDF</a>
        </div>
    </div>
</div>
