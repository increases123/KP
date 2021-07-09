<?php 
	$qry1 = "SELECT * from slots ORDER BY slot_id DESC;";
	$result1 = mysqli_query($conn, $qry1);
	$qry2 = "SELECT 
				hari, 
				GROUP_CONCAT( if(nama_slot='Slot 1',jam,NULL) ) AS 'Slot 1',
				GROUP_CONCAT( if(nama_slot='Slot 2',jam,NULL) ) AS 'Slot 2',
				GROUP_CONCAT( if(nama_slot='Slot 3',jam,NULL) ) AS 'Slot 3',
				GROUP_CONCAT( if(nama_slot='Slot 4',jam,NULL) ) AS 'Slot 4',
				GROUP_CONCAT( if(nama_slot='Slot 5',jam,NULL) ) AS 'Slot 5',
				GROUP_CONCAT( if(nama_slot='Slot 6',jam,NULL) ) AS 'Slot 6',
				GROUP_CONCAT( if(nama_slot='Slot 7',jam,NULL) ) AS 'Slot 7',
				GROUP_CONCAT( if(nama_slot='Slot 8',jam,NULL) ) AS 'Slot 8',
				GROUP_CONCAT( if(nama_slot='Slot 9',jam,NULL) ) AS 'Slot 9'
			FROM slots
			GROUP BY hari
			ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')";
	$result2 = mysqli_query($conn, $qry2);
	// print_r(mysqli_fetch_all($result2, MYSQLI_ASSOC));
?>

<div class="row">
	<div class="col-lg-12">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<div class="row">
					<div class="col-sm-8">
						<h6 class="m-0 font-weight-bold text-primary text-capitalize"><?php echo isset($_GET['page']) ? dash($_GET['page']) : dash('beranda') ?></h6>
					</div>
					<?php if ($_SESSION['login_level'] == 1):?>
					<div class="col-sm-4">
						<button class="btn-primary btn btn-sm float-right" type="button" id="new_sched"><i class="fa fa-plus"></i> Tambah Jadwal</button>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="card-body">
				<table class="table table-bordered small">
						<?php
						$counter = 0;
						$data = array();
							while($row2 = mysqli_fetch_all($result2, MYSQLI_ASSOC)) {
								$counter++;
								if ($counter == 1) {
						echo '<tr>';
									foreach($row2[0] as $key => $val) { echo '<th class="text-capitalize">'.$key.'</th>'; }
						echo '</tr>';
									foreach($row2 as $key => $val) {
						echo '<tr>';
									foreach($val as $slot) { echo '<td>'.$slot.'</td>'; }
						echo '</tr>';
									}
								}
							}
						?>
				</table>
				<?php if ($_SESSION['login_level'] == 1): ?>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>#No.</th>
							<th>Hari</th>
							<th>Slot</th>
							<th>Jam</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$num = 0;
							while($row = mysqli_fetch_assoc($result1)) {
								$num++;
								$slot_id=$row['slot_id'];
								$hari=$row['hari']; 
								$nama_slot=$row['nama_slot']; 
								$jam=$row['jam']; 
						?>
						<tr>
							<td><?php echo $num; ?></td>
							<td><?php echo $hari; ?></td>
							<td><?php echo $nama_slot; ?></td>
							<td><?php echo $jam; ?></td>
							<td class="text-right">
								<a class="edit_sched" title="Edit" data-toggle="tooltip" data-id="<?php echo $slot_id; ?>"><i class="fa fa-pencil-alt"></i></a>
								<a class="delete_sched" title="Hapus" data-toggle="tooltip" data-id="<?php echo $slot_id; ?>"><i class="fa fa-trash-alt"></i></a>
							</td>
						</tr>   
						<?php } ?>     
					</tbody>
				</table>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<style>td:empty{background-color:#F0CAA8;}table.table td a {cursor:pointer;display:inline-block;margin:0 5px;min-width:24px;max-width:100px;}table.table td a.edit_sched{color: #FFC107;}table.table td a.delete_sched{color: #E34724;}table.table td i {font-size:19px;}</style>
<script>
	
$('#new_sched').click(function(){
	uni_modal('Slot Jadwal Baru','<?php echo base_url(); ?>halaman/kelola-jadwal.php')
})
$('.edit_sched').click(function(){
	uni_modal('Edit Slot Jadwal','<?php echo base_url(); ?>halaman/kelola-jadwal.php?slot_id='+$(this).attr('data-id'))
})
$('.delete_sched').click(function(){
		_conf("Apakah yakin ingin menghapus data ini?","hapus_jadwal",[$(this).attr('data-id')])
	})
	function hapus_jadwal($id){
		$.ajax({
			url:'<?php echo base_url(); ?>/lib/ajax.php?action=hapus_jadwal',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					showalert("Data berhasil ditambahkan",'alert-success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>
