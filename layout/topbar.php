<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
	<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
		<i class="fa fa-bars"></i>
	</button>
	<div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
		<span class="text-uppercase font-weight-bold text-gray-800"><?php echo $namasistem; ?></span>
	</div>
	<ul class="navbar-nav ml-auto">
		<li class="nav-item dropdown no-arrow d-sm-none">
			<span class="nav-link">SISFO</span>
		</li>
		<li class="nav-item dropdown no-arrow">
			<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
			data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['login_nama']; ?></span>	
			</a>
			<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
			aria-labelledby="userDropdown">
				<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal" data-backdrop="static" data-keyboard="false">
					<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
					Logout
				</a>
			</div>
		</li>
	</ul>
</nav>
