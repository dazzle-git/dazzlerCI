<?php $this->load->view($viewFolder . "includes/meta"); ?>
<script src="<?php echo site_url('assets/lib/bootstrap/js/jquery.bootpag.min.js'); ?>"></script>
<script src="<?php echo site_url('assets/js/ajax.js'); ?>"></script>    
<script type="text/javascript">
    $("[rel=tooltip]").tooltip();
    $(function() {
        $('.demo-cancel-click').click(function() {
            return false;
        });
    });
    
</script>

<body>
    <?php $this->load->view($viewFolder . "includes/navbar.php"); ?>

    <?php $this->load->view($viewFolder . "includes/menu.php"); ?>
    <div class="content">

        <div class="header">

            <h1 class="page-title">Media</h1>
        </div>

        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('/admin'); ?>">Home</a> <span class="divider">/</span></li>
            <li class="active">Media</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">

                <!--                <div class="btn-toolbar">
                                    <button class="btn btn-primary"><i class="icon-plus"></i> New User</button>
                                    <button class="btn">Import</button>
                                    <button class="btn">Export</button>
                                    <div class="btn-group">
                                    </div>
                                </div>-->
                <div class="well" id="content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th style="width: 26px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $key => $item) { ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $item->videoName; ?></td>
                                    <td><?php echo substr($item->description, 0, 15); ?></td>
                                    <td><?php echo $item->uploadtype; ?></td>
                                    <td nowrap="nowrap">
                                        <a href="<?php echo site_url("admin/restricted/".$item->mediaId);?>">
										<?php if($item->restrict == 1) { ?>
										<i class="icon-unlock"></i>
										<?php } else { ?>
										<i class="icon-lock"></i>
										<?php } ?>
										</a>
										<a href="<?php echo site_url("admin/mediadetails/".$item->mediaId);?>"><i class="icon-search"></i></a>
                                        <a href="javascript:" role="button" data-toggle="modal" onClick="deleteMe(<?php echo $item->mediaId;?>)"><i class="icon-remove"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination demo2">

                </div>

                <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Delete Confirmation</h3>
                    </div>
                    <div class="modal-body">
                        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button class="btn btn-danger" data-dismiss="modal">Delete</button>
                    </div>
                </div>

                <?php $this->load->view($viewFolder . "includes/footer"); ?>

            </div>
        </div>
    </div>
</body>
<script>
    $('.demo2').bootpag({
        total: <?php echo $total; ?>,
        page: 1,
        maxVisible: 10
    }).on('page', function(event, num) {
           ajaxloadPage(num); // or some ajax content loading...
    });
</script>
    