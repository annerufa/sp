@extends('navbar')

@section('content')

<div id="content">
	<div class="container-fluid">
		@if($data['status']=='true')
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
							<table id="example" class="table table-striped table-bordered" cellspacing="0">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Topik</th>
										<th class="text-center">Jumlah Dokumen</th>
										<th class="text-center">Nilai Similarity</th>
										<th class="text-center">Nilai Variabilitas</th>
										<th class="text-center">Aksi</th>
									</tr>
								</thead>

								<tbody>
									<?php $i = 0; $idDet=0;?>
									@foreach ($data['kluster'] as $no=>$c)
									<?php $doks = explode(" ", $c); $j = count($doks);?>
									<tr>
										<td scope="row">{{ ++$i}}</td>
										<td>{{ $no }}</td>
										<td>{{ $j }} dokumen</td>
										<td>{{ $c->similaritas }}</td>
										<td>{{ $c->variabilitas }}</td>
										<td>
											<a class="btn btn-sm btn-success" href="#"><i class='fa fa-search'></i></a>
											<a  href="" onclick="add(34);"><button type="button" class="btn btn-sm btn-danger" ><i class='fa fa-trash'></i></button></a> 
											
										</td>
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
		
		<div id="detailKluster">
			<div class="row">
				<div class="col-xs-12 col-md-12">
					<div class="panel panel-success" >
						<div class="panel-heading">
							<h3 class="panel-title">pengelompokkan dokumen</h3>
						</div>
						<div class="panel-body">
							<div class='alert alert-danger alert-dismissable'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close' style='right: 4px;'>×</a>
								<strong>Dokumen belum dikelompokkan.</strong> Segera lakukan isi form pengelompokkan di bawah untuk mendapatkan hasil.
							</div>
							<form action="{{ route('clustering') }}" class="group-border-dashed" method="post">
								{{ csrf_field() }}
								<div class="col-md-6">
									<div class="form-group">
										<label>Jumlah Topik</label>
										<input class="form-control" type="number" name="k" placeholder="Rekomendasi : 8" required="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Jumlah Perulangan</label>
										<input class="form-control" type="number" name="iter" placeholder="Rekomendasi : 3" required="">
									</div>
								</div>
								<div  class="col-md-12"><button type="submit" class="btn btn-floyd break-bottom-10 pull-right">KELOMPOKKAN</button></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif


		@foreach($data['cluster'] as $k)
		<div class="row" id="detailRow" >
			<div class="col-xs-12 col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<span class="panel-title pull-left text-black"><i class="fa fa-fw fa-users"></i> Detail Cluster Pengelompokkan </span>
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
									<?php $i = 0; $idDet=0;?>
									@foreach ($data['kluster'] as $no=>$c)
									<?php $doks = explode(" ", $c); $j = count($doks);?>
									<tr>
										<td scope="row">{{ ++$i}}</td>
										<td>{{ $no }}</td>
										<td>{{ $j }} dokumen</td>
										<td>{{ $c->similaritas }}</td>
										<td>{{ $c->variabilitas }}</td>
										<td>
											<a class="btn btn-sm btn-success" href="#"><i class='fa fa-search'></i></a>
											<a  href="" onclick="add(34);"><button type="button" class="btn btn-sm btn-danger" ><i class='fa fa-trash'></i></button></a> 
											
										</td>
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
		@endforeach
	</div>
</div>
<script>
function add()
{
	alert('yooooooo');
}
</script>
@endsection