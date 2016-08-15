<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css" />
    <script type="text/javascript" src="//code.jquery.com/jquery-1.12.3.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="./js/defaults.js"></script>
    <script type="text/javascript" src="./js/jquery.cookie.js"></script>
    <script type="text/javascript" src="./js/jquery.browserLanguage.js"></script>
    <script type="text/javascript" src="./js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="./js/localforage.min.js"></script>
    <script type="text/javascript" src="./js/socket.js"></script>
    <script type="text/javascript" src="./js/storage.js"></script>
    <script type="text/javascript" src="./js/script.js"></script>
    <style type="text/css">
        table caption select {
            margin-right: 16px;
        }
        .dataTables_filter {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col-md-12">
            <div class="pull-right change-lang">
                <?php $addURL = $_GET['currency'] ? '&currency='.$_GET['currency'] : '' ?>
                <a href="?<?php echo $addURL ?>" data-name="en">English</a>
                <a href="?lang=ru<?php echo $addURL ?>" data-name="ru">Русский</a>
                <a href="?lang=uk<?php echo $addURL ?>" data-name="uk">Українська</a>
            </div>
        </div>