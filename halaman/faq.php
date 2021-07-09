<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800 text-uppercase">
		<?php echo isset($_GET['page']) ? dash($_GET['page']) : dash('beranda') ?>
	</h1>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card shadow mb-4">
			<a href="#faq1" class="d-block card-header py-3" data-toggle="collapse"
				role="button" aria-expanded="true" aria-controls="collapseCardExample">
				<h6 class="m-0 font-weight-bold text-primary">
					Ini Judul/pertanyaan faq1
				</h6>
			</a>
			<div class="collapse show" id="faq1">
				<div class="card-body">
					ini isi/jawaban faq
				</div>
			</div>
		</div>
		<div class="card shadow mb-4">
			<a href="#faq2" class="d-block card-header py-3" data-toggle="collapse"
				role="button" aria-expanded="true" aria-controls="collapseCardExample">
				<h6 class="m-0 font-weight-bold text-primary">
					Ini Judul/pertanyaan faq2
				</h6>
			</a>
			<div class="collapse" id="faq2">
				<div class="card-body">
					ini isi/jawaban faq2
				</div>
			</div>
		</div>
	</div>
</div>
