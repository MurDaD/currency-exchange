<?php include 'header.php' ?>
<div class="row">
    <div class="col-md-6">
        <table class="display main list" cellspacing="0" width="100%">
            <caption class="filter"></caption>
            <caption>
                From: <input type="text" id="datetimepicker1"/>
                To: <input type="text" id="datetimepicker2"/>
                <input type="button" class="filterDates" value="Filter" />
                <input type="button" class="clearFilter" value="Clear" />
            </caption>
            <thead>
                <tr>
                   <th>ID</th>
                   <th><?php echo _('Bank') ?></th>
                   <th><?php echo _('Currency') ?></th>
                   <th><?php echo _('Buy') ?></th>
                   <th><?php echo _('Sell') ?></th>
                   <th><?php echo _('Updated') ?></th>
                </tr>
            </thead>
            <tfoot>
            <tr>
                <th>ID</th>
                <th><?php echo _('Bank') ?></th>
                <th><?php echo _('Currency') ?></th>
                <th><?php echo _('Buy') ?></th>
                <th><?php echo _('Sell') ?></th>
                <th><?php echo _('Updated') ?></th>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-md-6">
        <table class="display popular" cellspacing="0" width="100%">
            <caption class="filter"></caption>
            <thead>
            <tr>
                <th>ID</th>
                <th><?php echo _('Bank') ?></th>
                <th><?php echo _('Currency') ?></th>
                <th><?php echo _('Buy') ?></th>
                <th><?php echo _('Sell') ?></th>
                <th><?php echo _('Updated') ?></th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<?php include 'footer.php' ?>