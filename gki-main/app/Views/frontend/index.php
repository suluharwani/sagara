<!DOCTYPE html>
<!--
* @version 1.0.0
* @link https://github.com/taraz14
* Development 2024 Pradhana for Church
-->
<?php
/**
 * @var CodeIgniter\View\View $this
 */

$uri = service('uri');
?>

<html lang="en">

<head>
    <title><?=$_ENV['name']?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="./assets/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="./assets/icomoon/icomoon.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="./assets/style.css">

</head>

<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">

    <div id="header-wrap">
        <?= $this->include('frontend/content/topbar') ?>
        <?= $this->include('frontend/content/navbar') ?>
    </div>
    <!--header-wrap-->

    <!-- Section -->
    <?php
    // echo $uri->getSegment(1);
    // die;
    $linked = $uri->getSegment(1);
    if ($linked == 'hut-gereja' || $linked == 'hut-ypk' || $linked == 'hut-pi') {
        $this->renderSection("content");
    } else {
        $section = [
            $this->include('frontend/section/billboard'),
            $this->include('frontend/section/clientHolder'),
            $this->include('frontend/section/featuredBooks'),
            $this->include('frontend/section/bestSelling'),
            $this->include('frontend/section/popularBooks'),
            $this->include('frontend/section/quotation'),
            $this->include('frontend/section/specialOffer'),
            $this->include('frontend/section/subscribe'),
            $this->include('frontend/section/latestBlog'),
            $this->include('frontend/section/downloadApp')
        ];
        foreach ($section as $content) {
            echo $content;
        }
    }
    ?>
    <!-- endSection -->

    <?= $this->include('frontend/content/footer') ?>
    <?= $this->include('frontend/content/footerBottom') ?>



    <script src="./assets/js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <script src="./assets/js/plugins.js"></script>
    <script src="./assets/js/script.js"></script>

</body>

</html>