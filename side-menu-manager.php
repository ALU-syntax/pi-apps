<?php include_once "side-menu.php";?>
<li <?php echo $listMenu["beranda"] ?> >
	<a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a>
</li>
<li <?php echo $listMenu["mutasi"] ?> >
    <a href="?module=part_masuk"><i class="fa fa-plus"></i> Data Mutasi Masuk </a>
</li>
<li <?php echo $listMenu["mutasi_keluar"] ?> >
    <a href="?module=part_keluar"><i class="fa fa-minus"></i> Data Mutasi Keluar </a>
</li>
<li <?php echo $listMenu["approval"] ?> >
    <!--<a href="?module=approval"><i class="fa fa-thumbs-o-up"></i> Approval Mutasi Keluar</a>-->
</li>

<li <?php echo $listMenu["laporan"] ?> >
	<a href="#">
		<i class="fa fa-file-text"></i> <span>Laporan</span> 
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li <?php echo $listMenu["lap_stok"] ?> >
			<a href="?module=lap_stok"><i class="fa fa-circle-o"></i> Stok Item</a>
		</li>
		<li <?php echo $listMenu["lap_mutasi"] ?>>
			<a href="?module=lap_part_masuk"><i class="fa fa-circle-o"></i> Mutasi Item </a>
		</li>
	</ul>
</li>
<li <?php echo $listMenu["password"] ?> >
	<a href="?module=password"><i class="fa fa-lock"></i> Ubah Password</a>
</li>