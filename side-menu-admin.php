<?php include_once "side-menu.php";?>
<li <?php echo $listMenu["beranda"] ?> >
	<a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a>
</li>
<li <?php echo $listMenu["sales"] ?> >
    <a href="?module=sales"><i class="fa fa-money"></i> Sales </a>
</li>
<li <?php echo $listMenu["setting"] ?> >
	<a href="#">
		<i class="fa fa-gear"></i> <span>Setting</span> 
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li <?php echo $listMenu["upload_part"] ?> >
			<a href="?module=upload_part"><i class="fa fa-folder"></i> Upload Item </a>
		</li>
		<li <?php echo $listMenu["upload_vend"] ?> >
			<a href="?module=upload_vend"><i class="fa fa-folder"></i> Upload Suplier </a>
		</li>
		<li <?php echo $listMenu["upload_sales"] ?> >
			<a href="?module=upload_sales"><i class="fa fa-folder"></i> Upload Sales </a>
		</li>
	</ul>
</li>
<li <?php echo $listMenu["master"] ?> >
	<a href="#">
		<i class="fa fa-database"></i> <span>Master Data</span> 
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li <?php echo $listMenu["part"] ?> >
			<a href="?module=part"><i class="fa fa-folder"></i> Data Item </a>
		</li>
		<li <?php echo $listMenu["produk"] ?> >
			<a href="?module=produk"><i class="fa fa-folder"></i> Data Produk </a>
		</li>
		<li <?php echo $listMenu["vend"] ?> >
			<a href="?module=vend"><i class="fa fa-folder"></i> Data Suplier </a>
		</li>
		<li <?php echo $listMenu["resto"] ?> >
			<a href="?module=resto"><i class="fa fa-folder"></i> Data Restoran </a>
		</li>
	</ul>
</li>
<li <?php echo $listMenu["request"] ?> >
    <a href="?module=part_request"><i class="fa fa-shopping-cart"></i> Pembelian </a>
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
<li <?php echo $listMenu["biaya"] ?> >
    <a href="?module=biaya"><i class="fa fa-dollar"></i> Data biaya </a>
</li>
<li <?php echo $listMenu["laporan"] ?> >
	<a href="#">
		<i class="fa fa-line-chart"></i> <span>Laporan</span> 
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
		<li <?php echo $listMenu["lap_rugilaba"] ?>>
			<a href="?module=lap_rugilaba"><i class="fa fa-circle-o"></i> Rugilaba </a>
		</li>
	</ul>
</li>
<li <?php echo $listMenu["user"] ?> >
	<a href="?module=user"><i class="fa fa-user"></i> Manajemen User</a>
</li>
<li <?php echo $listMenu["password"] ?> >
	<a href="?module=password"><i class="fa fa-lock"></i> Ubah Password</a>
</li>