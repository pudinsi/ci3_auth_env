<?php defined('__NAJZMI_PUDINTEA__') OR exit('No direct script access allowed'); ?>
	<script type="text/javascript">
		var table = $('#pdn_mytable');
		$(document).ready( function () {
			var token = "<?=$this->security->get_csrf_hash();?>";
			table.DataTable({ 
				"processing": true,
				"serverSide": true,
				"order": [],
				"ajax": {
					"url"  : "<?=base_url($pdn_url.'/data_json');?>",
					"type" : "POST",
					"data" : function ( d ) {
								d.<?=$this->security->get_csrf_token_name();?> = token;
							}
				},
				//optional
				"lengthMenu"	: [[10, 25, 50], [10, 25, 50]],
				"oLanguage"     : {
					"sProcessing":   "Sedang memproses...",
					"sLengthMenu":   "Tampilkan _MENU_ entri data",
					"sZeroRecords":  "Tidak ditemukan data yang sesuai",
					"sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri data",
					"sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
					"sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
					"sInfoPostFix":  "",
					"sSearch":       "Cari:",
					"sUrl":          "",
					"oPaginate": {
						"sFirst":    "Pertama",
						"sPrevious": "Sebelumnya",
						"sNext":     "Selanjutnya",
						"sLast":     "Terakhir"
					}
				},
				"columnDefs": [
					{
						"targets": [0,5],
						"sClass": "text-center",
						"orderable": false,
					},
				],
			});
			table.on('xhr.dt', function ( e, settings, json, xhr ) {
				token = json.<?=$this->security->get_csrf_token_name();?>;
			});
		});
		
		function reloadTable(){
			table.DataTable().ajax.reload();
		}
	</script>
	<script type="text/javascript">
		var saveData;
		var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
		var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
		var modal 		= $('#pdnTambahData');
		var formTambah 	= $('#formTambah');
		var modalTitle 	= $('#pdnModalTitle');
		var btnSimpan 	= $('#btnSimpan');
		
		function btnTambahData(){
			saveData = 'tambah';
			formTambah[0].reset();
			modal.modal('show');
			modalTitle.text('Tambah Data');
		}
		
		function simpan(){
			btnSimpan.text('Mohon Tunggu....');
			btnSimpan.attr('disabled', true);
			if (saveData == 'tambah'){
				url = "<?=base_url('pegawai/add');?>";
			}else{
				url = "<?=base_url('pegawai/update');?>";
			}
			$.ajax({
				type		: "POST",
				url 		: url,
				data 		: formTambah.serialize(),
				dataType 	: "JSON",
				headers		: {'X-Requested-With': 'XMLHttpRequest'},
				complete	: function(response){
					csrfName = response.responseJSON.csrfName;
					csrfHash = response.responseJSON.csrfHash;
				},
				success: function(response){
					if(response.status == 'success'){
						modal.modal('hide');
						$.notify({
							title: "Success : ",
							message: 'Data Berhasil ditambah',
							icon: 'fa fa-check'
						}, {
							type: "info"
						});
						
						reloadTable();
					}else{
						modal.modal('hide');
						$.notify({
							title: "Error : ",
							message: 'Data Tidak Berhasil ditambah',
							icon: 'fa fa-times'
						}, {
							type: "danger"
						});
					};
				},
				error: function(){
					modal.modal('hide');
					$.notify({
						title: "Error : ",
						message: 'Error Aksess',
						icon: 'fa fa-times'
					}, {
						type: "danger"
					});
				}
			});
		}
	
		function byid(id,type){
			if (type == 'edit'){
				saveData = 'edit';
				formTambah[0].reset();
			};
			
			$.ajax({
				type		: "GET",
				url 		: "<?=base_url('pegawai/byid/');?>" + id,
				dataType 	: "JSON",
				success: function(response){
					if (type == 'edit'){
						//console.log(response);
						btnSimpan.text('Update Data');
						btnSimpan.attr('disabled', false);
						modalTitle.text('Update Data');
						$('[name="id"]').val(response.id);
						$('[name="nama_depan"]').val(response.nama_depan);
						$('[name="nama_belakang"]').val(response.nama_belakang);
						$('[name="email"]').val(response.email);
						$('[name="telpon"]').val(response.telpon);
						modal.modal('show');
					}else{
						swal({
							title: "Apakah anda yakin?",
							text: "Ingin menghapus data ini!",
							type: "warning",
							showCancelButton: true,
							confirmButtonText: "Ya",
							cancelButtonText: "Tidak",
							closeOnCancel: true,
							showCancelButton: true,
						}, function(isConfirm) {
							if (isConfirm) {
								hapusData(response.id);
							}
						});
					};
				}
			});
		}
		
		function hapusData(id){
			$.ajax({
				type		: "GET",
				url 		: "<?=base_url('pegawai/hapus/');?>" + id,
				dataType 	: "JSON",
				success: function(response){
					//console.log(response);
					if(response.status == 'success'){
						$.notify({
							title: "Success : ",
							message: 'Data Berhasil dihapus',
							icon: 'fa fa-check'
						}, {
							type: "info"
						});
					}else{
						$.notify({
							title: "Error : ",
							message: 'Data Tidak Berhasil dihapus',
							icon: 'fa fa-times'
						}, {
							type: "danger"
						});
					};
					//Reload Tablenya
					reloadTable()
				},
				error: function(){
					$.notify({
						title: "Error : ",
						message: 'Error Aksess',
						icon: 'fa fa-times'
					}, {
						type: "danger"
					});
				}
			});
		}
	</script>

