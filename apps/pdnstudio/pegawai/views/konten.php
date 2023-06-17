<?php defined('__NAJZMI_PUDINTEA__') OR exit('No direct script access allowed'); ?>
 <main class="app-content">
		<div class="app-title">
			<div>
				<h1><i class="fa fa-th-list"></i> <?php echo isset($pdn_info) ? $pdn_info	: 'Tidak Ada | Pudin Project'; ?></h1>
			</div>
			<ul class="app-breadcrumb breadcrumb side">
				<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
				<li class="breadcrumb-item active"><a href="#">Data <?php echo isset($pdn_info) ? $pdn_info	: 'Tidak Ada | Pudin Project'; ?></a></li>
			</ul>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="mb-3">
					<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pdnTambahData"><i class="fa fa-fw fa-lg fa-check-circle">&nbsp;</i>Tambah Data</button> -->
					<button type="button" class="btn btn-primary" onclick="btnTambahData()"><i class="fa fa-fw fa-lg fa-check-circle">&nbsp;</i>Tambah Data</button>
				</div>
				<div class="tile">
					<div class="tile-body">
						<div class="table-responsive">
							<table class="table table-hover" id="pdn_mytable" width="100%" style="width:100%;">
								<thead>
									<tr>
										<th width="7%">No</th>
										<th>Nama Depan</th>
										<th>Nama Belakang</th>
										<th>Email</th>
										<th>Telpon</th>
										<th width="12%">Action</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="pdnTambahData" tabindex="-1" aria-labelledby="pdnModalTitle" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<?= form_open_multipart('#', 'class="form-horizontal" id="formTambah" role="form"'); ?>
					<input type="hidden" id="id" name="id" value="">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="pdnModalTitle">PDN Title</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col">
									<label for="nama_depan">Nama Depan</label>
									<input type="text" class="form-control" id="nama_depan" name="nama_depan" placeholder="Nama depan">
								</div>
								<div class="col">
									<label for="nama_belakang">Nama Belakang</label>
									<input type="text" class="form-control" id="nama_belakang" name="nama_belakang"placeholder="Nama belakang">
								</div>
							</div>
							<div class="form-group mt-2">
								<label for="email">Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Email Pegawai">
							</div>
							<div class="form-group mt-2">
								<label for="telpon">Telpon</label>
								<input type="telpon" class="form-control" id="telpon" name="telpon" placeholder="Telpon Pegawai">
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" id="btnSimpan" onclick="simpan()">Simpan</button>
						</div>
					</div>
				<?= form_close();?>
			</div>
		</div>
    </main>
