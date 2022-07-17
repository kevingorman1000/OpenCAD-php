<?php

/**

Open source CAD system for RolePlaying Communities.
Copyright (C) 2017 Shane Gill

This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

This program comes with ABSOLUTELY NO WARRANTY; Use at your own risk.
**/
	if(session_id() == '' || !isset($_SESSION)) {
	// session isn't started
	session_start();
	}
	require_once(__DIR__ . '/../../oc-config.php');
	require_once( ABSPATH . '/oc-functions.php');
	require_once( ABSPATH . '/oc-settings.php');
	require_once( ABSPATH . "/oc-includes/adminActions.inc.php");
	require_once( ABSPATH . "/oc-includes/dataActions.inc.php");

    isAdminOrMod();

    $accessMessage = "";
	if(isset($_SESSION['accessMessage']))
	{
		$accessMessage = $_SESSION['accessMessage'];
		unset($_SESSION['accessMessage']);
	}
    $successMessage = "";
    if(isset($_SESSION['successMessage']))
    {
        $successMessage = $_SESSION['successMessage'];
        unset($_SESSION['successMessage']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include ( ABSPATH . "/".OCTHEMES."/".THEME."/includes/header.inc.php"); ?>

<body class="app header-fixed">

	<header class="app-header navbar">
    	<button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
			<span class="navbar-toggler-icon"></span>
		</button>
		<?php require_once( ABSPATH . OCTHEMEINC ."/admin/topbarNav.inc.php" ); ?>
		<?php require_once( ABSPATH . "/" . OCTHEMES ."/". THEME ."/includes/topProfile.inc.php"); ?>
	</header>

    <div class="app-body">
		<main class="main">
		<div class="breadcrumb" />
		<div class="container-fluid">
		<div class="animated fadeIn">
		    <div class="card">
			    <div class="card-header">
		            <em class="fa fa-align-justify"></em> <?php echo lang_key("RADIOCODE_MANAGER"); ?>
                </div>
			    <div class="card-body">
					<?php echo $accessMessage;?>
					<?php getRadioCodes();?>
				</div>
				<!-- /.row-->
			  </div>
			</div>
			<!-- /.card-->
		</main>

		</div>

			<?php require_once ( ABSPATH . "/" . OCTHEMES ."/". THEME ."/includes/footer.inc.php"); ?>

    <!-- Edit Weapon Modal -->
    <div class="modal fade" id="editRadioCodeModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="editRadioCodeModal">Edit Radio Codes</h4>
                </div>
                <!-- ./ modal-header -->
                <div class="modal-body">
                    <form role="form" method="post" action="<?php echo BASE_URL; ?>/actions/dataActions.inc.php"
                        class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 control-label">Radio Code</label>
                            <div class="col-md-9">
                                <input type="text" name="code" class="form-control" id="code" required />
                            </div>
                            <!-- ./ col-sm-9 -->
                        </div>
                        <!-- ./ form-group -->
                        <div class="form-group row">
                            <label class="col-md-3 control-label">Code Description</label>
                            <div class="col-md-9">
                                <input type="text" name="codeDescription" class="form-control" id="codeDescription" required />
                            </div>
                            <!-- ./ col-sm-9 -->
                        </div>
                        <!-- ./ form-group -->
                </div>
                <!-- ./ modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" name="id" id="id" aria-hidden="true">
                    <input type="submit" name="editRadioCode" class="btn btn-primary" value="Edit Radio Code" />
                </div>
                <!-- ./ modal-footer -->
                </form>
            </div>
            <!-- ./ modal-content -->
        </div>
        <!-- ./ modal-dialog modal-lg -->
    </div>
    <!-- ./ modal fade bs-example-modal-lg -->

	<?php
	require_once( ABSPATH . OCTHEMEMOD . "/admin/globalModals.inc.php");
	require_once( ABSPATH . OCTHEMEINC ."/scripts.inc.php" ); ?>

    <script>
    $(document).ready(function() {
        $('#allRadioCodes').DataTable({});
    });
    </script>

    <script>
    $('#editRadioCodeModal').on('show.bs.modal', function(e) {
        var $modal = $(this),
            id = e.relatedTarget.id;

        $.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo BASE_URL . OCINC; ?>/dataActions.inc.php',
            data: {
                'getRadioCodeDetails': 'yes',
                'id': id
            },
            success: function(result) {
                console.log(result);
                data = JSON.parse(result);

                $('input[name="code"]').val(data['code']);
                $('input[name="codeDescription"]').val(data['codeDescription']);
                $('input[name="id"]').val(data['id']);
            },

            error: function(exception) {
                alert('Exeption:' + exception);
            }
        });
    })
    </script>


</body>

</html>