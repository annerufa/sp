@extends('navbar')

@section('content')

<div id="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-md-6">
				<div class="panel panel-success" style="height: 230px;">
					<div class="panel-heading">
						<h3 class="panel-title">Atur Pengelompokkan</h3>
					</div>
					<div class="panel-body">
						<form class="form-horizontal"  action="{{ route('clustering') }}" method="post">
							{{ csrf_field() }}
							<div class="form-group">
								<label for="k" class="col-sm-4 control-label">Jumlah Topik</label>
								<div class="col-sm-8">
									<input type="number" class="form-control input-md" name="k" placeholder="Rekomendasi : 8"> 
								</div>
							</div>
							<div class="form-group">
								<label for="iter" class="col-sm-4 control-label">Jumlah Perulangan</label>
								<div class="col-sm-8">
									<input type="number" class="form-control input-md" name="iter" placeholder="Rekomendasi 5">
								</div>
							</div>
							<div><button type="submit" style="width: 100%;" class="btn btn-floyd break-bottom-10">KELOMPOKKAN</button></div>

						</form>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6">
				<div class="panel panel-success"  style="height: 230px;">
					<div class="panel-heading">
						<h3 class="panel-title">Hasil Pengelompokkan</h3>
					</div>
					<div class="panel-body">
						<p>Total Topik :  10 topik</p>
						<p>Terakhir pengelompokkan :  11/11/1212</p>
						<p>Total dokumen termasuk : 344 dokumen </p>
						<p>Total dokumen belum  : 4 dokumen </p>
					</div>
				</div>
			</div>
		</div>
		@if($data['status']=='true')
		<div class="row">
			<div class="col-xs-12 col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<span class="panel-title pull-left text-black"><i class="fa fa-fw fa-users"></i> Hasil Pengelompokkan </span>
						<!-- Add Button -->
						<div class="btn-group btn-group-sm pull-right" role="group">
							<a href="" class="btn btn-success break-bottom-10" ><i class="fa fa-fw fa-plus"></i> <span class="hidden-sm">Simpan</span></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="panel-body">
						<div class=" table-responsive table-full">
							<table id="example" class="table table-striped table-bordered" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Topik</th>
										<th class="text-center">Jumlah Dokumen</th>
										<th class="text-center">Nilai Similarity</th>
										<th class="text-center">Aksi</th>
									</tr>
								</thead>

								<tbody>
									<?php $i = 0;?>
									@foreach ($data['cluster'] as $no=>$c)
									<tr>
										<td scope="row">{{ ++$i}}</td>
										<td>{{ $no }}</td>
										<td>{{ count($c) }} dokumen</td>
										<td>{{ $data['overSim'][$no] }}</td>
										<td><button class="btn btn-warning"  value="$" id="step1" onclick="getc(this)"><i class="fa fa-fw fa-angle-left"></i> <span class="hidden-sm">detail</span></button></td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>


					<div class="panel-footer">
						<span class="panel-footer-text text-grey text-size-12"><i class="fa fa-info-circle"></i> last edited at 02/01/2016 18:00</span>
					</div>
				</div>
			</div>
		</div>
		@else
		<div class="row">
			<div class="col-xs-12 col-md-6">
				<div class="panel panel-success"  style="height: 230px;">
					<div class="panel-heading">
						<h3 class="panel-title">Hasil Pengelompokkan</h3>
					</div>
					<div class="panel-body">
						<p>Total Topik :  10 topik</p>
						<p>Terakhir pengelompokkan :  11/11/1212</p>
						<p>Total dokumen termasuk : 344 dokumen </p>
						<p>Total dokumen belum  : 4 dokumen </p>
					</div>
				</div>
			</div>
		</div>
		@endif
		<div id="detailKluster">
			<div class="row">
				<div class="col-xs-12 col-md-6">
					<div class="panel panel-success"  style="height: 230px;">
						<div class="panel-heading">
							<h3 class="panel-title">Detail Cluster</h3>
						</div>
						<div class="panel-body">
							<p>Total Topik :  10 topik</p>
							<p>Terakhir pengelompokkan :  11/11/1212</p>
							<p>Total dokumen termasuk : 344 dokumen </p>
							<p>Total dokumen belum  : 4 dokumen </p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- modal -->
<div class="modal fade" id="my" role="dialog">
	<div class="modal-dialog modal-info" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<span class="close">&times;</span>
				<h2>Detail CLuster 1</h2>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="#" method="post">

					<div class="form-group">
						<label class="col-sm-2 control-label" style="color: white">Nama </label>
						<div class="col-sm-10">
							<input type="text" name="nama" value="" class="form-control" id="" placeholder="nama" style="color: black">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" style="color: white">Username</label>
						<div class="col-sm-10">
							<input type="text" name="alamat" value="" class="form-control" id="inputPassword3" placeholder="Alamat" style="color: black">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" style="color: white">Password</label>
						<div class="col-sm-10">
							<input type="text" name="pass" class="form-control" style="color: black" value="" id="mypass" placeholder="Password">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-primary">Simpan</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal" style="color: black">Batal</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="modal-footer"></div>
	</div>
</div>
<script>
  function getc() {
    $('#detailKluster').show();
    }
</script>
@endsection