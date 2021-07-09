<?php 
include('../lib/config.php');
if(isset($_GET['slot_id'])){
$jadwal = $conn->query("SELECT * FROM slots where slot_id =".$_GET['slot_id']);
foreach($jadwal->fetch_array() as $k =>$v) {
    $slot_jam = $meta['nama_slot'].', '.$meta['jam'];
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
<form action="" class="user" id="kelola-jadwal">
<input type="hidden" name="slot_id" value="<?php echo isset($meta['slot_id']) ? $meta['slot_id']: '' ?>">
    <div class="form-group">
        <label for="hari">Hari</label>
        <select name="hari" id="hari" class="custom-select">
        <option value="Senin" <?php echo isset($meta['hari']) && $meta['hari'] == 'Senin' ? 'selected': '' ?>>Senin</option>
        <option value="Selasa" <?php echo isset($meta['hari']) && $meta['hari'] == 'Selasa' ? 'selected': '' ?>>Selasa</option>
        <option value="Rabu" <?php echo isset($meta['hari']) && $meta['hari'] == 'Rabu' ? 'selected': '' ?>>Rabu</option>
        <option value="Kamis" <?php echo isset($meta['hari']) && $meta['hari'] == 'Kamis' ? 'selected': '' ?>>Kamis</option>
        <option value="Jumat" <?php echo isset($meta['hari']) && $meta['hari'] == 'Jumat' ? 'selected': '' ?>>Jumat</option>
        <option value="Sabtu" <?php echo isset($meta['hari']) && $meta['hari'] == 'Sabtu' ? 'selected': '' ?>>Sabtu</option>
        <option value="Minggu" <?php echo isset($meta['hari']) && $meta['hari'] == 'Minggu' ? 'selected': '' ?>>Minggu</option>
        </select>
    </div>
    <div class="form-group">
        <label for="slot_jam">Slot, Jam</label>
        <select name="slot_jam" id="slot_jam" class="custom-select">
        <option value="Slot 1, 10.00 - 11.00" <?php echo isset($slot_jam) && $slot_jam == "Slot 1, 10.00 - 11.00" ? 'selected': '' ?>>Slot 1, 10.00 - 11.00</option>
        <option value="Slot 2, 11.00 - 12.00" <?php echo isset($slot_jam) && $slot_jam == "Slot 2, 11.00 - 12.00" ? 'selected': '' ?>>Slot 2, 11.00 - 12.00</option>
        <option value="Slot 3, 12.00 - 13.00" <?php echo isset($slot_jam) && $slot_jam == "Slot 3, 12.00 - 13.00" ? 'selected': '' ?>>Slot 3, 12.00 - 13.00</option>
        <option value="Slot 4, 13.00 - 14.00" <?php echo isset($slot_jam) && $slot_jam == "Slot 4, 13.00 - 14.00" ? 'selected': '' ?>>Slot 4, 13.00 - 14.00</option>
        <option value="Slot 5, 14.00 - 15.00" <?php echo isset($slot_jam) && $slot_jam == "Slot 5, 14.00 - 15.00" ? 'selected': '' ?>>Slot 5, 14.00 - 15.00</option>
        <option value="Slot 6, 15.00 - 16.00" <?php echo isset($slot_jam) && $slot_jam == "Slot 6, 15.00 - 16.00" ? 'selected': '' ?>>Slot 6, 15.00 - 16.00</option>
        <option value="Slot 7, 16.00 - 17.00" <?php echo isset($slot_jam) && $slot_jam == "Slot 7, 16.00 - 17.00" ? 'selected': '' ?>>Slot 7, 16.00 - 17.00</option>
        <option value="Slot 8, 19.00 - 20.00" <?php echo isset($slot_jam) && $slot_jam == "Slot 8, 19.00 - 20.00" ? 'selected': '' ?>>Slot 8, 19.00 - 20.00</option>
        <option value="Slot 9, 20.00 - 21.00" <?php echo isset($slot_jam) && $slot_jam == "Slot 9, 20.00 - 21.00" ? 'selected': '' ?>>Slot 9, 20.00 - 21.00</option>
        </select>
    </div>
</form>
</div>
<script>
	$('#kelola-jadwal').submit(function(e){
		e.preventDefault();
		$.ajax({
			url:'<?php echo base_url(); ?>lib/ajax.php?action=tambah_jadwal',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					showalert("Data berhasil ditambahkan",'alert-success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	})
</script>
