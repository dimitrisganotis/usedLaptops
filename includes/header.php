<?php
	$projectName = 'usedLaptops';
	include ('functions.php');
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="To usedLaptops είναι μια on-line υπηρεσία αγγελιών μεταχειρισμένων laptops">
    <meta name="keywords" content="usedLaptops, αγγελίες, μεταχειρισμένα, laptop">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" type="image/png" href="../images/favicon.png">
    <link rel="stylesheet" type="text/css" href="<?php echo getCSS();?>"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto%7CRoboto+Slab" rel="stylesheet">
</head>

<body>
<div id="page-container">

    <!-- HEADER -->
    <header id="header">
        <div class="container">
            <h1 id=logo><a href="/"><?php echo $projectName; ?></a></h1>
            <?php include('nav.php');?>
        </div>
    </header>
