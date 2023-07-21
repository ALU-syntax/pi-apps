<?php  
/* panggil file database.php untuk koneksi ke database */
require_once "config/database.php";
require_once "config/fungsi.php";

?>
<div style="height: auto; color: white;padding: 14px 0px 0px 0px;float: left;font-size: 16px;"> 
    <span style="margin-right:5px"><?php echo tglIndonesia(date('D, d F Y')); ?></span>
</div>

<?php if($_SESSION['hak_akses']=='Super Admin') : ?>
<li class="dropdown">
    <?php 
        $date = new DateTime();
        $date->modify('-' . 3 . ' day');
        
        $query = mysqli_query($mysqli, "SELECT kode_request, jatuh_tempo, sum(qty*harga) AS jumlah FROM is_part_req WHERE jatuh_tempo<='" . $date->format('Y-m-d') . "' AND status_bayar='Unpaid' GROUP BY kode_request") or die('Kesalahan menampilkan notif jatuh tempo: ' . mysqli_error($mysqli));
    ?>
    <a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="#">
        <i class="glyphicon glyphicon-bell"></i>
        <span class="badge badge-primary"><?php echo mysqli_num_rows($query)?></span>
        <span class="caret"></span>
    </a>
    
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="">
        <li class="dropdown-header">Satus Pembelian Belum Dibayar</li>  
        <?php
        
        
        while($data = mysqli_fetch_assoc($query)){
            echo '<li><a href="?module=form_part_request&form=edit&kode='  . $data[kode_request] . '">' . $data['kode_request'] .' - ' . date('d-m-Y', strtotime($data['jatuh_tempo'])) . ' - ' . number_format($data['jumlah']) .  '</a></li>';
        }
        
        ?>
    </ul>
    
    
</li>
<?php endif; ?>

<?php 
// fungsi query untuk menampilkan data dari tabel user
$query = mysqli_query($mysqli, "SELECT id_user, nama_user, foto, hak_akses FROM is_users WHERE id_user='$_SESSION[id_user]'")
                                or die('Ada kesalahan pada query tampil Manajemen User: '.mysqli_error($mysqli));

// tampilkan data
$data = mysqli_fetch_assoc($query);
?>

<li class="dropdown user user-menu">

  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
  
  <!-- User image -->
  <?php  
  if ($data['foto']=="") { ?>
    <img src="images/user/user-default.png" class="user-image" alt="User Image"/>
  <?php
  }
  else { ?>
    <img src="images/user/<?php echo $data['foto']; ?>" class="user-image" alt="User Image"/>
  <?php
  }
  ?>

	<span class="hidden-xs"><?php echo $data['nama_user']; ?> <i style="margin-left:5px" class="fa fa-angle-down"></i></span>
  </a>
  <ul class="dropdown-menu">
    <!-- User image -->
    <li class="user-header">

      <?php  
      if ($data['foto']=="") { ?>
        <img src="images/user/user-default.png" class="img-circle" alt="User Image"/>
      <?php
      }
      else { ?>
        <img src="images/user/<?php echo $data['foto']; ?>" class="img-circle" alt="User Image"/>
      <?php
      }
      ?>

      <p>
        <?php echo $data['nama_user']; ?>
        <small><?php echo $data['hak_akses']; ?></small>
      </p>
    </li>
    
    <!-- Menu Footer-->
    <li class="user-footer">
      <div class="pull-left">
        <a style="width:80px" href="?module=profil" class="btn btn-default btn-flat">Profil</a>
      </div>

      <div class="pull-right">
        <a style="width:80px" data-toggle="modal" href="#logout" class="btn btn-default btn-flat">Logout</a>
      </div>
    </li>
  </ul>
</li>
