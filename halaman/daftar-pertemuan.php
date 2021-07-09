<?php
// session_start();
	$pasien = $conn->query("SELECT * FROM users where level = 3");
	while($row = $pasien->fetch_assoc()) {
		$p_arr[$row['user_id']] = $row;
	}

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
FROM (SELECT s.*,
	CASE WHEN b.booking_id IS NULL THEN 'YES' ELSE 'NO' END available
	FROM slots s
	LEFT
	JOIN bookings b
	ON b.slot_id = s.slot_id) subdata
	WHERE subdata.available = 'YES'
GROUP BY hari
ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');";
	$result2 = mysqli_query($conn, $qry2);
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<div class="row">
					<div class="col-sm-8">
						<h6 class="m-0 font-weight-bold text-primary text-capitalize"><?php echo isset($_GET['page']) ? dash($_GET['page']) : dash('beranda') ?></h6>
					</div>
					<?php if ($_SESSION['login_verified'] == 1): ?>
					<div class="col-sm-4">
						<button class="btn-primary btn btn-sm float-right" type="button" id="new_appointment"><i class="fa fa-plus"></i> Buat Jadwal</button>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="card-body">
<?php
	$query =	"SELECT DISTINCT hari FROM
				(SELECT s.*,
				CASE WHEN b.booking_id IS NULL THEN 'YES' ELSE 'NO' END available
				FROM slots s
				LEFT
				JOIN bookings b
				ON b.slot_id = s.slot_id) subdata
                WHERE subdata.available = 'YES'";
	$getslots = mysqli_query($conn,$query) or die ('Query Gagal');
$days = [
  'Minggu' => 0,
  'Senin' => 1,
  'Selasa' => 2,
  'Rabu' => 3,
  'Kamis' => 4,
  'Jumat' => 5,
  'Sabtu' => 6
];
$dowmap = array();
while($row = mysqli_fetch_assoc($getslots))
{
	$dowmap[] = "". $days[$row['hari']]. "";
	// print_r($dowmap);
}
?>
<?php
$qrypas = "SELECT * FROM users where level = 3";
$qrypasres = mysqli_query($conn, $qrypas);
$qrypasrow = mysqli_fetch_all($qrypasres, MYSQLI_ASSOC);
?>
<div id="buat_jadwal" style="display: none;">
<form action="" id="kirim_jadwal" class="user">
<input type="hidden" name="user_id" value="<?php echo $_SESSION['login_level'] != 1 ? $_SESSION['login_user_id'] : '';?>">
<input type="hidden" name="nama" value="<?php echo $_SESSION['login_level'] != 1 ? $_SESSION['login_nama'] : '';?>">
<input type="hidden" name="email" value="<?php echo $_SESSION['login_level'] != 1 ? $_SESSION['login_email'] : '';?>">
<div class="float-right">
	<button class="btn btn-primary btn-sm" type="submit">Kirim</button>
	<button class="btn btn-secondary btn-sm" id="cancel_appointment">Batal</button>
</div>
<?php if($_SESSION['login_level'] == 1): ?>
<div class="form-group col-6">
	<label for="pasien">Pasien : </label>
	<select name="pasien" id="pasien" class="custom-select" required>
	<option value="">--Pilih Pasien--</option>
	<?php foreach($qrypasrow as $pasrow): ?>
		<option value="<?php echo $pasrow['user_id'].','.$pasrow['nama'].','.$pasrow['email']; ?>"><?php echo $pasrow['user_id'].' - '.$pasrow['nama']; ?></option>
	<?php endforeach; ?>
	</select>
</div>
<?php endif; ?>
Pilih Tanggal :
<div class="form-group">
	<input type="text" placeholder="Tanggal" name="hari_tanggal" class="date date-pick" id="datepicker" required oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" readonly>
	<i class="fa fa-calendar" aria-hidden="true"></i>
</div>

Pilih Jam (Silakan pilih tanggal terlebih dahulu) :
<table id="maplist" class="table table-bordered small tbl tr td">
	<thead>
		<?php
		$counter = 0;
		$data = array();
			while($row2 = mysqli_fetch_all($result2, MYSQLI_ASSOC)) {
				$counter++;
				if ($counter == 1) {
		echo '<tr>';
					foreach($row2[0] as $key => $val) { echo '<th class="text-capitalize">'.$key.'</th>'; }
		echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
					foreach($row2 as $key => $val) {
		echo '<tr data-val="'. $val['hari'] .'">';
						foreach($val as $slot) {
							echo '<td><input type="radio" id="'.$slot.'" name="jam" value="'.$slot.'" required><label for="'.$slot.'">'.$slot.'</label></td>';
						}
		echo '</tr>';
					}
				}
			}
		?>
	</tbody>
</table>
<style>table.tbl tr td:first-child,.tbl tr th:first-child { display: none; }</style>
</form>
</div>
				<table class="table table-bordered">
					<thead>
						<tr>
						<th>Waktu</th>
						<th>Pasien</th>
						<th>Status</th>
						<?php if ($_SESSION['login_level'] == 1): ?>
						<th>Action</th>
						<?php endif; ?>
					</tr>
					</thead>
					<?php 
					$where = '';
					if($_SESSION['login_level'] == 3)
						$where = " where user_id = ".$_SESSION['login_user_id'];
					$qry = $conn->query("SELECT * FROM bookings ".$where." order by booking_id desc ");

					while($row = $qry->fetch_assoc()): ;
					?>
					
					<tr>
						<td><?php echo $row['hari_tanggal'].', '.$row['jam']; ?></td>
						<td><?php echo $p_arr[$row['user_id']]['nama'] ?></td>
						<td>
							<?php if($row['status'] == 0): ?>
								<span class="badge badge-warning">Pending</span>
							<?php endif ?>
							<?php if($row['status'] == 1): ?>
								<span class="badge badge-info">Diterima</span>
							<?php endif ?>
							<?php if($row['status'] == 2): ?>
								<span class="badge badge-danger">Ditolak</span>
							<?php endif ?>
							<?php if($row['status'] == 3): ?>
								<span class="badge badge-secondary">Selesai</span>
							<?php endif ?>
						</td>
						<?php if ($_SESSION['login_level'] == 1): ?>
						<td class="text-center">
							<!-- <button  class="btn btn-info btn-sm terima_app" type="button" data-id="<?php //echo $row['booking_id'] ?>">Terima</button>
							<button  class="btn btn-danger btn-sm tolak_app" type="button" data-id="<?php //echo $row['booking_id'] ?>">Tolak</button> -->
							<span class="dropdown mb-4">
								<button class="btn btn-primary btn-sm dropdown-toggle" type="button"
									id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
									aria-expanded="false">
									Update
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<?php if($row['status'] == 0): ?>
									<a class="dropdown-item text-info terima_app" data-id="<?php echo $row['booking_id']; ?>" href="#">TERIMA</a>
									<a class="dropdown-item text-danger tolak_app" data-id="<?php echo $row['booking_id']; ?>" href="#">TOLAK</a>
								<?php endif; ?>
								<?php if($row['status'] != 0 && $row['status'] != 3): ?>
									<a class="dropdown-item text-primary selesai_app" data-id="<?php echo $row['booking_id']; ?>" href="#">SELESAI</a>
									<?php endif; ?>
								</div>
							</span>
							<a href="#" title="Detail Pasien" class="btn btn-info btn-sm view_data" data-id="<?php echo $row['user_id']; ?>"><i class="fas fa-info-circle"></i></a>
						</td>
						<?php endif; ?>
					</tr>
				<?php endwhile; ?>
				</table>
				<div>
				<div>History Pertemuan :</div>
				<table class="table table-bordered">
					<thead>
						<tr>
						<th>Waktu</th>
						<th>Pasien</th>
						<th>Status</th>
					</tr>
					</thead>
					<?php 
					$where = '';
					if($_SESSION['login_level'] == 3)
						$where = " where user_id = ".$_SESSION['login_user_id'];
					$qry = $conn->query("SELECT * FROM bookings_history ".$where." order by history_id desc ");

					while($row = $qry->fetch_assoc()): ;
					?>
					
					<tr>
						<td><?php echo $row['hari_tanggal'].', '.$row['jam']; ?></td>
						<td><?php echo $p_arr[$row['user_id']]['nama'] ?></td>
						<td>
							<?php if($row['status'] == 0): ?>
								<span class="badge badge-warning">Pending</span>
							<?php endif ?>
							<?php if($row['status'] == 1): ?>
								<span class="badge badge-info">Diterima</span>
							<?php endif ?>
							<?php if($row['status'] == 2): ?>
								<span class="badge badge-danger">Ditolak</span>
							<?php endif ?>
							<?php if($row['status'] == 3): ?>
								<span class="badge badge-secondary">Selesai</span>
							<?php endif ?>
						</td>
					</tr>
				<?php endwhile; ?>
				</table></div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="userDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Detail User</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body" id="detail_user"></div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<script>
var array = <?php echo json_encode($dowmap); ?>;
console.log(array);
$(function() {
	$("#datepicker").datepicker({
		dateFormat: 'DD, dd-mm-yy',
		beforeShowDay: my_check,
		minDate: 0
	});
});

var avail = array;
function my_check(in_date) {
var day = in_date.getDay();
	if ($.inArray(day.toString(), avail) >= 0) {
		return [true, "av", 'Available'];
	} else {
		return [false, "notav", "Not Available"];
	}
}

function datepicker () {
	if ($('#datepicker').length) {
		$('#datepicker').datepicker({
			duration: '',
			changeMonth: false,
			changeYear: false,
			yearRange: '2010:2020',
			showTime: false,
			time24h: true,
			minDate: 0
		});

		$.datepicker.regional['id'] = {
			monthNames: [ "Januari","Februari","Maret","April","Mei","Juni",
			"Juli","Agustus","September","Oktober","Nopember","Desember" ],
			monthNamesShort: [ "Jan","Feb","Mar","Apr","Mei","Jun",
			"Jul","Agus","Sep","Okt","Nop","Des" ],
			dayNames: [ "Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu" ],
			dayNamesShort: [ "Min","Sen","Sel","Rab","kam","Jum","Sab" ],
			dayNamesMin: [ "Mg","Sn","Sl","Rb","Km","Jm","Sb" ],
			weekHeader: "Mg",
			dateFormat: "DD, dd-mm-yy",
			firstDay: 1,
		};
		$.datepicker.setDefaults($.datepicker.regional['id']);
		$('.fa-calendar').click(function() {
			$("#datepicker").focus();
		});
	}
}

$(window).on('load', function() {
	(function ($) {
		datepicker();
	})(jQuery);
});

$('#datepicker').keypress(function(e) {
    e.preventDefault();
});

$('#datepicker').change(function() {
	$('input[name="time"]').prop('checked', false);
	val = $('#datepicker').val();
	var res = val.split(",")[0];
    $("#maplist tbody tr").hide().filter("[data-val='" + res + "']").show();
}).change();

$('#pasien').change(function() {
	var vals = $(this).val().split(",");
	$('input[name="user_id"]').val(vals[0]);
	$('input[name="nama"]').val(vals[1]);
	$('input[name="email"]').val(vals[2]);
});

$("#new_appointment").click(function(){
  $("#buat_jadwal").show();
});

$("#cancel_appointment").click(function() {
  $(this).closest('form').find("input[type=radio], input[type=text]").val("");
  $("#buat_jadwal").hide();
});

$('.view_data').click(function(){
		var data_id = $(this).data("id")
		$.ajax({
			url: "<?php echo base_url(); ?>/halaman/kelola-user.php",
			method: "POST",
			data: {data_id: data_id},
			success: function(data){
				$("#detail_user").html(data)
				$("#userDetail").modal('show')
			}
		})
	});

$('#kirim_jadwal').submit(function(e){
	e.preventDefault();
	// var f = document.getElementById('kirim_jadwal').getElementsByTagName("INPUT");
	// for (var i = 0; i < f.length; i++)
	// console.log(f[i].name + ' ' + f[i].value);
	$('#kirim_jadwal button[type="submit"]').attr('disabled',true).html('Memproses...');
	if($(this).find('.alert-danger').length > 0 ) {
		$(this).find('.alert-danger').remove();
	}
	$.ajax({
		url:'<?php echo base_url(); ?>lib/ajax.php?action=kirim_jadwal',
		method:'POST',
		data:$(this).serialize(),
		success:function(resp) {
			console.log(resp);
			if(resp == 1) {
				location.reload();
			} else {
				showalert('Gagal terkirim.','alert-danger');
				$('#kirim_jadwal button[type="submit"]').removeAttr('disabled').html('Kirim');
			}
		}
	})
})

$('.terima_app').click(function(e){
	e.preventDefault();
	$(this).attr('disabled',true).html('Memproses...');
	if($(this).find('.alert-danger').length > 0 ) {
		$(this).find('.alert-danger').remove();
	}
	$.ajax({
		// url:'<?php //echo base_url(); ?>lib/ajax.php?action=terima_app?id='+$(this).attr('data-id'),
		url:'<?php echo base_url(); ?>lib/ajax.php?action=terima_app',
		method:'POST',
		data:{id:$(this).attr('data-id')},
		success:function(resp) {
			console.log(resp);
			if(resp == 1) {
				location.reload();
			} else {
				showalert('Gagal terkirim.','alert-danger');
				$(this).removeAttr('disabled').html('Kirim');
			}
		}
	})
})
$('.tolak_app').click(function(e){
	e.preventDefault();
	$(this).attr('disabled',true).html('Memproses...');
	if($(this).find('.alert-danger').length > 0 ) {
		$(this).find('.alert-danger').remove();
	}
	$.ajax({
		// url:'<?php //echo base_url(); ?>lib/ajax.php?action=tolak_app?id='+$(this).attr('data-id'),
		url:'<?php echo base_url(); ?>lib/ajax.php?action=tolak_app',
		method:'POST',
		data:{id:$(this).attr('data-id')},
		success:function(resp) {
			console.log(resp);
			if(resp == 1) {
				location.reload();
			} else {
				showalert('Gagal terkirim.','alert-danger');
				$(this).removeAttr('disabled').html('Kirim');
			}
		}
	})
})
$('.selesai_app').click(function(){
		_conf("Apakah yakin ingin menandai data ini dengan 'SELESAI'?","selesai_app",[$(this).attr('data-id')])
	})
	function selesai_app($id){
		$.ajax({
			url:'<?php echo base_url(); ?>/lib/ajax.php?action=selesai_app',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				console.log(resp);
				if(resp==1) {
					showalert("Data berhasil disimpan",'alert-success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	}
</script>
