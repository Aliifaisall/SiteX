<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Project $project
 */

require_once 'lib/phpqrcode/qrlib.php';

//$qrType = $this->request->getQuery('type');

//Generate updated checkin QR

$codeContents = $this->Url->build(['controller' => 'Checkins', 'action' => 'add',  '?' => ['project' => $project->id]], ['fullBase' => true]);
//$currentDateTime = date('y-m-d-h-i-s');
$directory = WWW_ROOT.'uploads'.DS.'qr_checkin'.DS.$project->id.DS;
is_dir($directory) || mkdir($directory);
$fileName = 'checkinQR';
$fileExtension = '.png';
$filePath = $directory.$fileName.$fileExtension;
QRcode::png($codeContents, $filePath);

//Generate updated induction material QR
$codeContents = $this->Url->build(['controller' => 'Signatures', 'action' => 'pending'], ['fullBase' => true]);
$directory = WWW_ROOT.'uploads'.DS.'qr_induction'.DS.$project->id.DS;
is_dir($directory) || mkdir($directory);
$fileName = 'inductionQR';
$fileExtension = '.png';
$filePath = $directory.$fileName.$fileExtension;
QRcode::png($codeContents, $filePath);

?>

<div class="row content">
    <div class="column-responsive column-80">
        <div class="projects view">
            <h3><?= 'Generate QR Codes for ' . h($project->name) ?></h3>
            <table class="table table-bordered" style="background-color:ghostwhite; max-width:800px">
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($project->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td>
                        <?= h($project->address_no .' '. $project->address_street) ?><br/>
                        <?= h($project->address_suburb) ?><br/>
                        <?= h($project->address_state .' '. $project->address_postcode) ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Project Status') ?></th>
                    <td><?= h($project->status) ?></td>
                </tr>
            </table>
        </div>
        <div>
            <a class="btn btn-block btn-primary" style="width: 200px" href="<?= $this->Url->build(
                ['controller' => 'Projects', 'action' => 'pdf', $project->id, '?' => ['type' => 'checkin']]) ?>">Download Checkin Poster</a>
            <a class="btn btn-block btn-primary" style="width: 200px" href="<?= $this->Url->build(
                ['controller' => 'Projects', 'action' => 'pdf', $project->id, '?' => ['type' => 'induction']]) ?>">Download Induction Poster</a>
        </div>
    </div>
</div>
