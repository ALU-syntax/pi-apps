<!-- Modal tambah data transaksi penjualan -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambah" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Input Data Transaksi Penjualan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form id="formTambah">
				<div class="modal-body">

					<div class="form-group">
						<label>Tanggal</label>
						<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" id="tanggal" name="tanggal" autocomplete="off" value="09-11-2018">
					</div>

					<div class="form-group">
						<label>Nama Barang</label>
						<input type="text" class="form-control" id="nama_barang" name="nama_barang" autocomplete="off">
					</div>

					<div class="form-group">
						<label>Harga Barang</label>
						<div class="input-group mb-2">
							<div class="input-group-prepend"><div class="input-group-text">Rp.</div></div>
							<input type="text" class="form-control" id="harga_barang" name="harga_barang" onkeyup="hitung_total_bayar(this)" onKeyPress="return goodchars(event,'0123456789.',this)" autocomplete="off">
						</div>
					</div>

					<div class="form-group">
						<label>Jumlah Beli</label>
						<input type="text" class="form-control" id="jumlah_beli" name="jumlah_beli" onkeyup="hitung_total_bayar(this)" onKeyPress="return goodchars(event,'0123456789',this)" autocomplete="off">
					</div>

					<div class="form-group">
						<label>Total Pembayaran</label>
						<div class="input-group mb-2">
							<div class="input-group-prepend"><div class="input-group-text">Rp.</div></div>
							<input type="text" class="form-control" id="total_bayar" name="total_bayar" autocomplete="off" readonly>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-info btn-submit" id="btnSimpan">Simpan</button>
					<button type="button" class="btn btn-secondary btn-reset" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>