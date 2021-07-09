<head>
	<title><?php echo isset($_GET['page']) ? dash($_GET['page']) : dash('beranda') ?> | <?php echo $namasistem; ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<link rel="shortcut icon" href="<?php echo base_url();?>assets/img/bg60x60.jpg">
	<link href="<?php echo base_url();?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>vendor/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/css/kp.min.css" rel="stylesheet">

	<script src="<?php echo base_url();?>vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url();?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url();?>vendor/DataTables/datatables.min.js"></script>
	<script src="<?php echo base_url();?>vendor/jquery-easing/jquery.easing.min.js"></script>
	<script src="<?php echo base_url();?>vendor/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/custom.js"></script>
	<script>
		$(document).ready( function () {
			// $('#myTable').DataTable();
			document.title = document.title.toUpperCase();
			$(".nav-<?php echo isset($_GET['page']) ? $_GET['page'] : 'beranda' ?>").addClass("active");
		});
	</script>

</head>
