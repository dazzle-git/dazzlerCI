<?php $this->load->view($viewFolder . "includes/meta"); ?>

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
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active">Media Item</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">


                <div class="block">
                    <p class="block-heading">Media Item</p>
                    <div class="block-body gallery">
                        <?php if($row[0]->uploadtype == "Audio") { ?>
                        <audio controls>
                            <source src="<?php echo site_url('images/media/'.$row[0]->bigSizeFile);?>" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio> 
                        <?php } else { ?>
                        <video width="320" height="240" controls>
                            <source src="<?php echo $row[0]->bigSizeFile;?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <?php } ?>
                        <div class="clearfix"></div>
                    </div>
                </div>



                <?php $this->load->view($viewFolder . "includes/footer"); ?>

            </div>
        </div>
    </div>

</body>
