<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */
?>
<div class="row content">
    <div class="column-responsive column-80">
        <div class="documents view">
            <?= $this->Flash->render() ?>
            <table class="table table-bordered" style="background-color:ghostwhite; max-width: 600px">
                <tr>
                    <th><?= __('Document Name') ?></th>
                    <td><?= h($document->name) ?></td>
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
            <div class="float-left">
                <style>
                    #content-desktop{
                        display: block;
                    }
                    #content-mobile{
                        display: none;
                    }
                    @media screen and (max-width: 768px) {

                        #content-desktop {display: none;}
                        #content-mobile {display: block;}

                    }
                </style>
                <div id="content-desktop">
                    <embed src="<?= $this->Url->build(DS.'uploads'.DS.$document->document_type.DS.$document->related_project_id.DS.$document->id.'.pdf') ?>" width="60%" height="1200px"/>
                </div>
                <a class="btn btn-block btn-primary" style="width: 200px" href="<?= $this->Url->build(
                    ['controller' => 'Documents', 'action' => 'download', $document->id]) ?>">Download PDF</a>
            </div>
        </div>
    </div>
    <style>
        .container{
            padding: 30px;
            float: left;
        }
    </style>
    <div class="float-left">

    </div>
    <br>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />

    <link rel="stylesheet" type="text/css" href="<?= $this->Url->build(DS.'css'.DS.'jquery.signature.css') ?>">

    <style>
        .kbw-signature {
            width: 100%;
            height: 200px;
        }

        #sig canvas {
            position: absolute;
            width: 100% !important;
            height: auto;
        }
    </style>
    <div class="container" id = "content-desktop">
        <div class="row">
              <div class="col-md-8 offset-md-3">
                <div class="card">
                    <h4><?= $document->declaration_text ?></h4>
                    <div class="card-body">
                        <form method="POST" action="<?= $this->Url->build(['controller' => 'Documents', 'action' => 'review',
                            $document->id, '?' => ['rid' => $this->request->getQuery('rid')]]) ?>">
                            <div class="col-md-12">
                                <label class="" for="">Draw Signature:</label>
                                <br />
                                <div id="sig"></div>
                                <br><br>
                                <button id="clear" class="btn btn-danger">Clear Signature</button>
                                <button class="btn btn-success">Sign Document</button>
                                <textarea id="signature" name="signed" style="display: none"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
           </div>
        </div>
    <div class = "container" id="content-mobile">
        <div class="row" id="content-mobile">
            <div class="col-md-8 offset-md-3" id="content-mobile">
                <div class="card" id="content-mobile">
                    <form method="POST" action="<?= $this->Url->build(['controller' => 'Documents', 'action' => 'review',
                        $document->id, '?' => ['rid' => $this->request->getQuery('rid')]]) ?>" id="content-mobile">
                    <h4 id="content-mobile">
                       <div> <?= $this->Form->checkbox('signature', [
                            'value' => 'Y',
                               'hiddenField' => 'N',
                        ]);?> </div><?= $document->declaration_text ?></h4>
                    <div class="card-body" id="content-mobile">
                            <div class="col-md-12" id="content-mobile">
                                <label class="" for="">
                                </label>
                                <br />
                                <div id="sig"></div>
                                <br><br>
                                <script>
                                    function myFunction() {
                                        // Get the checkbox
                                        var checkBox = document.getElementById("checkbox");
                                        // If the checkbox is checked, display the output text
                                        if (checkBox.checked == true){
                                            text.style.display = "block";
                                        } else {
                                            text.style.display = "none";
                                        }
                                    }
                                </script>
                                <button class="btn btn-success">Sign Document</button>
                                <textarea id="signature" name="signed" style="display: none"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    </div>


    <!-- These scripts need to be imported properly, if they haven't been already: -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= $this->Url->build(DS.'js'.DS.'jquery.signature.js') ?>"></script>

    <script type="text/javascript">
        var sig = $('#sig').signature({
            syncField: '#signature',
            syncFormat: 'PNG'
        });
        $('#clear').click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature").val('');
        });
    </script>
</div>
