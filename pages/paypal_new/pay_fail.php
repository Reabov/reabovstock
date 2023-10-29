<!DOCTYPE html>
<html lang="<?=$CCpu->lang?>" class="page">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>

    <?mysqli_query($db,"UPDATE ws_orders SET `pay_status` = '3' WHERE id = '".$_SESSION['order_id_pay']."' ");?>
</head>
<body class="page__body" id="body">

<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>

<main class="main">
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/breadcrumbs.php")?>
    <div class="container">
        <div class="section-title">
            <h2><?=$page_data['title']?></h2>
        </div>
        <div class="col-xs-12">
            <?=$page_data['text']?>
        </div>
    </div>

</main>
<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>

</body>

</html>