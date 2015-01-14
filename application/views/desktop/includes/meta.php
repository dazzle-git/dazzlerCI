<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="" dir="ltr">

    <head lang="" dir="ltr">
        <meta http-equiv="expires" content="Wed, 26 Feb 1997 08:21:57 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="Cache-Control" content="no-cache" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="" />
        <meta name="description" content="Meta Description" />
        <meta name="keywords" content="Meta Keywords" />
        <title>Dazzler</title>

        <?php for ($t = 0; $t < count($styles); $t++) { ?>
            <link rel="stylesheet" href="<?php echo $styles[$t]; ?>" type="text/css" media="all" />
        <?php } ?>


        <?php for ($t = 0; $t < count($jscripts); $t++) { ?>
            <script type="text/javascript" src="<?php echo $jscripts[$t]; ?>"></script>
        <?php } ?>
        <!--[if lt IE 9]>
                        <script type="text/javascript" src="http://fusionfit.co/beta/js/respond.min.js"></script>
                        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
                <![endif]-->

        <?php if ($this->router->fetch_method() == "profile") { ?>
            <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
                <style>
                    .ui-dialog .ui-state-error { padding: .3em; }  
                    label, input { display:block; }
                    input.text { margin-bottom:12px; width:95%; padding: .4em; }
                    fieldset { padding:0; border:0; margin-top:25px; }
                    #dialog-form{ width: 400px; }
                </style>   
                <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
                <script>
                    $(function() {
                        var dialog, form;

                        function addUser() {
                            var valid = true;
                            allFields.removeClass("ui-state-error");
                            valid = valid && checkLength(name, "username", 3, 16);
                            valid = valid && checkLength(email, "email", 6, 80);
                            valid = valid && checkLength(password, "password", 5, 16);
                            valid = valid && checkRegexp(name, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter.");
                            valid = valid && checkRegexp(email, emailRegex, "eg. ui@jquery.com");
                            valid = valid && checkRegexp(password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9");
                            if (valid) {
                                $("#users tbody").append("<tr>" +
                                        "<td>" + name.val() + "</td>" +
                                        "<td>" + email.val() + "</td>" +
                                        "<td>" + password.val() + "</td>" +
                                        "</tr>");
                                dialog.dialog("close");
                            }
                            return valid;
                        }
                        dialog = $("#dialog-form").dialog({
                            autoOpen: false,
                            height: 500,
                            width: 450,
                            modal: true,
                            buttons: {
                                "Save": addUser,
                                Cancel: function() {
                                    dialog.dialog("close");
                                }
                            },
                            close: function() {
                                $("#updateForm")[0].reset();

                            }
                        });

                        $("#update-user").button().on("click", function() {
                            dialog.dialog("open");
                        });
                    });
                </script>
            <?php } ?>
            <?php
            if (isset($alertMessage)) {
                if ($alertMessage["message"] != "") {
                    ?>
                    <script type="text/javascript">
                        $(document).ready(function() {


                            $.msgBox({
                                content: "<?php echo $alertMessage["message"]; ?>",
                                type: "<?php echo $alertMessage["type"]; ?>"
                            });
                        });
                    </script>

        <?php
    }
}
?>
           

    </head>
