<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Skripsi</title>
	<link rel="stylesheet" href="<?php echo e(URL::asset('assets/plugins/bootstrap/css/bootstrap.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(URL::asset('assets/plugins/fontawesome/css/fontawesome.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(URL::asset('assets/plugins/fontawesome/css/all.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(URL::asset('assets/css/theme-floyd.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(URL::asset('assets/css/theme-helper.css')); ?>">
	<link rel="stylesheet" href="../assets/css/other.css">
<!-- 	<link rel="stylesheet" href="<?php echo e(URL::asset('assets/plugins/datatable/dataTables.bootstrap.min.css')); ?>" />
	<link rel="stylesheet" href="<?php echo e(URL::asset('assets/css/styleTambahan.css')); ?>"/> -->

</head>
<body>
	<div id="wrapper"> 
		<div id="sidebar">
			<div id="sidebar-wrapper">
				<div class="sidebar-title">
					<!-- <span class="text-size-19 text-loose">SKRIPSI CLUSTERING </span><br> -->
					<span> <h3 class="panel-title" style="color: #ff4d76;">SISTEM PENGELOMPOKKAN</h3></span>
					<span> <h3 class="panel-title" style="color: #ff4d76;">SKRIPSI</h3></span>
				</div>
				<div class="sidebar-avatar">
					<div class="sidebar-avatar-image"><img src="../assets/images/profil.PNG" alt="" class="img-circle"></div>
					<div class="sidebar-avatar-text">Lee Yong Qin</div>
				</div>
				<!-- <br><br> -->
				<ul class="sidebar-nav">
					<li class="sidebar-close"><a href="#"><i class="fa fa-fw fa-close"></i></a></li>
					<li class="<?php echo e($page == "home" ? "active" : ""); ?>"><a href="<?php echo e(route('home')); ?>"><i class="fa fa-fw fa-star"></i><span>Beranda</span></a></li>
					<li class="<?php echo e($page == "dok" ? "active" : ""); ?>"><a href="<?php echo e(route('dok.index')); ?>"><i class="fa fa-fw fa-archive"></i><span>Dokumen Skripsi</span></a></li>
					<li class="<?php echo e($page == "kata" ? "active" : ""); ?>"><a href="<?php echo e(route('kata.index')); ?>"><i class="fas fa-fw fa-list"></i><span>Kata Unik</span></a></li>
					<li class="<?php echo e($page == "cluster" ? "active" : ""); ?>"><a href="<?php echo e(route('cluster')); ?>"><i class="fas fa-fw fa-tablet"></i><span>Pengelompokkan</span></a></li>
					<li class="<?php echo e($page == "test" ? "active" : ""); ?>"><a href="<?php echo e(route('dok.index')); ?>"><i class="fas fa-fw fa-check"></i><span>Pengujian</span></a></li>
					<li class="<?php echo e($page == "craw" ? "active" : ""); ?>"><a href="<?php echo e(route('dok.index')); ?>"><i class="fa fa-fw fa-wrench"></i><span>Crawling</span></a></li>
				</ul>
				<div class="sidebar-footer">
					<hr style="border-color: #DDD">
					created by <a href="http://ainuls.github.io" target="_blank" class="text-default">AR</a><br>
				</div>
			</div>
		</div>
		<div id="main-panel">
			<div id="top-nav">
				<nav class="navbar navbar-default">
					<div class="container-fluid">
						<div class="navbar-header">
							<!-- Navbar toggle button -->
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
								<i class="fas fa-bars"></i>
							</button>
							<!-- Sidebar toggle button -->
							<button type="button" class="sidebar-toggle">
								<i class="fas fa-bars"></i>
							</button>
							<a class="navbar-brand text-size-24" href="#"><i class="far fa-file-word"></i> TEMA </a>
						</div>
						<div class="collapse navbar-collapse" id="menu">			
							<ul class="nav navbar-nav navbar-right">
								<!-- modal -->
								<div class="modal fade" id="my" role="dialog">
									<div class="modal-dialog modal-info" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<span data-dismiss="modal" class="close">&times;</span>
												<h2>Ubah Profil</h2>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="#" method="post">
													
													<div class="form-group">
														<label class="col-sm-2 control-label" style="color: white">Nama </label>
														<div class="col-sm-10">
															<input type="text" name="nama" value="" class="form-control" id="" placeholder="nama" style="color: black">
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-2 control-label" style="color: white">Username</label>
														<div class="col-sm-10">
															<input type="text" name="alamat" value="" class="form-control" id="inputPassword3" placeholder="Alamat" style="color: black">
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-2 control-label" style="color: white">Password</label>
														<div class="col-sm-10">
															<input type="text" name="pass" class="form-control" style="color: black" value="" id="mypass" placeholder="Password">
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-offset-2 col-sm-10">
															<button type="submit" class="btn btn-primary">Simpan</button>
															<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<div class="modal-footer"></div>
									</div>
								</div>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<div class="navbar-avatar-image "><img style="width: 30px;" src="../assets/images/profil.PNG" alt="" class="img-circle"></div>
									</a>
									<ul class="dropdown-menu">
										<li><a data-toggle="modal" data-target="#my"><i class="fas fa-user-circle"></i> Profil</a></li>
										<li>
											<a href="#"
											onclick="event.preventDefault();
											document.getElementById('logout-form').submit();">
											<i class="fa fa-fw fa-sign-out-alt"></i>
											Logout
										</a>

										<form id="logout-form" method="POST" style="display: none;">
										</form>
									</li> 
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>

			<?php echo $__env->yieldContent('content'); ?>

		</div>
	</div>
</body>

<script src="<?php echo e(URL::asset('assets/plugins/jquery/jquery-3.1.1.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/bootstrap/js/bootstrap.min.js')); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('assets/plugins/datatables/jquery.dataTables.min.css')); ?>" />
<script src="<?php echo e(URL::asset('assets/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/theme-floyd.js')); ?>"></script>
<!-- <script src="<?php echo e(URL::asset('assets/plugins/jquery/jquery-3.1.1.min.js')); ?>"></script> -->
<!-- <script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
	<script src="../assets/plugins/datatable/dataTables.bootstrap.min.js"></script> -->

	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		} );
	</script>
	<script>
		$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
			$("#success-alert").slideUp(500);
		});

	</script>
	<script src="<?php echo e(URL::asset('assets/js/theme-floyd.js')); ?>"></script>
	</html><?php /**PATH C:\xampp\htdocs\template2\resources\views/navbar.blade.php ENDPATH**/ ?>