<?php 
include('../lib/config.php');
if(isset($_POST['data_id'])) {
    $users = $conn->query("SELECT * FROM users where user_id =".$_POST['data_id'])->fetch_array();
}
?>
<div class="container-fluid">
    <div class="form-group">
        <p>USER_ID : <?php echo $users['user_id']; ?></p>
        <p>Nama : <?php echo $users['nama']; ?></p>
        <p>Email : <?php echo $users['email']; ?></p>
    </div>
    <div class="form-group">
    </div>
</div>
