<!DOCTYPE html>
<html>
<head>
    <title><?= h($title) ?></title>
    <?php
    use Cake\Routing\Router;
    ?>
    <style>
        @page {
            margin-top: 20px !important;
            margin-bottom: 20px !important;
            margin-right: 50px !important;
            margin-left: 50px !important;
            padding: 0px 0px 0px 0px !important;
        }
        body{
            font-family: 'Calibri', sans-serif;
        }
        heading{
            text-align: center;
            font-family: 'Calibri', sans-serif;
            font-size: 72px;
            font-weight: bold;
            color: green;
        }

        .column {
            float: left;
            width: 50%;
        }

    </style>
</head>
<body>
<div class="row" style="text-align:center">
    <heading>SITE SIGN-IN</heading><br/>
    <b><?= h($name) ?></b><br/>
    <?= h($address) ?><br/>
</div>
<div class="row">
    <div class="column">
        <img src="img/cosmic-333.png" />
    </div>
    <div class="column">
        <img src="uploads/qr_checkin/<?= $id ?>/checkinQR.png" />
    </div>
</div>
<br/>
<div class="row" style="text-align:center"><b>Site Contact:</b> Damian Marchese | 0409 393 909 | damian@cosmicproperty.com.au</div>
<br/>
<br/>
<br/>
<div class="row" style="text-align:center">
    <heading>SITE SIGN-IN</heading><br/>
    <b><?= h($name) ?></b><br/>
    <?= h($address) ?><br/>
</div>
<div class="row">
    <div class="column">
        <img src="img/cosmic-333.png" />
    </div>
    <div class="column">
        <img src="uploads/qr_checkin/<?= $id ?>/checkinQR.png" />
    </div>
</div>
<br/>
<div class="row" style="text-align:center"><b>Site Contact:</b> Damian Marchese | 0409 393 909 | damian@cosmicproperty.com.au</div>

</body>
</html>
