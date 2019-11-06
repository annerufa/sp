@extends('navbar')

@section('content')

<div id="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<span class="panel-title pull-left text-black"><i class="fa fa-fw fa-users"></i> Tabel Kata Unik </span>
						<!-- Add Button -->
						<div class="btn-group btn-group-sm pull-right" role="group">
							<a href="{{route('tfidf')}}" class="btn btn-success break-bottom-10" ><i class="fa fa-fw fa-plus"></i> <span class="hidden-sm">Hitung Bobot Kata</span></a>
						</div>

						<div class="clearfix"></div>

					</div>
					<?php echo @$data['message']?>	

					<div class="panel-body table-responsive table-full">
						<table id="example" class="table table-striped table-bordered" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Kata Unik</th>
									<th class="text-center">Terdapat Pada</th>
									<th class="text-center">Bobot Kata</th>
									<!-- <th class="text-center">Aksi</th> -->
								</tr>
							</thead>

							<tbody>
								@foreach ($data['kata'] as $no=>$k)
								<tr>
									<td scope="row">{{ ++$no}}</td>
									<td>{{ $k->kata }}</td>
									<td>{{ $k->totDok }} dokumen</td>
									<td>{{ $k->idf }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>


					<div class="panel-footer">
						<span class="panel-footer-text text-grey text-size-12"><i class="fa fa-info-circle"></i> last edited at 02/01/2016 18:00</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection