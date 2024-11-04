<?php
echo view('home/layout/head.php');
echo view('home/layout/header.php');
(isset($content))? $cont = $content: $cont='';
//deklarasi content di controller
echo $cont;
echo view('home/layout/footer.php');





