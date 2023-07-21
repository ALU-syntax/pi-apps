<?php include_once "side-menu.php";?>
<li <?php echo $listMenu["beranda"] ?> >
	<a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a>
</li>
<li <?php echo $listMenu["sales"] ?> >
    <a href="?module=sales"><i class="fa fa-money"></i> Sales </a>
</li>
<li <?php echo $listMenu["request"] ?> >
    <a href="?module=part_request"><i class="fa fa-shopping-cart"></i> Pembelian </a>
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
		<li <?php echo $listMenu["lap_rugilaba"] ?>>
			<a href="?module=lap_rugilaba"><i class="fa fa-circle-o"></i> Rugilaba </a>
		</li>
	</ul>
</li>
