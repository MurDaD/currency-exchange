<?php include 'header.php' ?>
    <div class="col-md-12">
        <?php $addURL = $_GET['lang'] ? 'lang='.$_GET['lang'] : '' ?>
        <h4><a href="?<?php echo $addURL ?>"><?php echo _('Back') ?></a></h4>
    </div>
<h3 class="title"></h3>
    <table class="display inner" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>ID</th>
            <th><?php echo _('Buy') ?></th>
            <th><?php echo _('Sell') ?></th>
            <th><?php echo _('Updated') ?></th>
        </tr>
        </thead>
    </table>
<?php include 'footer.php' ?>