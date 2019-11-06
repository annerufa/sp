@extends('navbar')
@section('content')

<div id="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				@if($data['status']=='edit')
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Ubah Data Penelitian Mahasiswa</h3>
						<span class="text-grey">These are the basic subtitle form elements</span>
					</div>
					<div class="panel-body">
						<form action="{{ route('penelitian.update' , $data['dokumen']->idDok ) }}" class="group-border-dashed" method="post">
						<input type="hidden" name="_method" value="PUT">
						{{ csrf_field() }}
							<div class="col-md-12">
								<div class="form-group">
									<label>Judul Skripsi</label>
									<input class="form-control" type="text" name="judul" value="{{$data['dokumen']->judul}}"  placeholder="Masukkan judul penelitian" required="">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Nama Peneliti</label>
									<input class="form-control" type="text" name="penulis" value="{{$data['dokumen']->penulis}}"  placeholder="Masukkan nama peneliti" required="">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Tanggal</label>
									<input class="form-control" type="date" name="date" value="{{$data['dokumen']->date}}" required="">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Fakultas</label>
									<select class="form-control" id="fakultas" name="idFakultas" required="">
										<option data-tokens="" value="">- Pilih Fakultas -</option>
										<option data-divider="true"></option>
										@foreach($data['fakultas'] as $f)
										<option value="{{$f->idFakultas}}" {{ $f->idFakultas == $data['dokumen']->idFakultas? 'selected' : '' }}>{{$f->namaFakultas}}</option>

										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Keywords</label>
									<input class="form-control" type="text" name="keywords"value="{{$data['dokumen']->keywords}}" required="">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Abstrak</label>
									<textarea name="abstrak" class="form-control">{{$data['dokumen']->abstrak}}"</textarea>
								</div>
							</div>
							<div class="col-md-12">
							<button type="submit" class="btn btn-primary break-bottom-10 pull-right">Simpan</button>
							</div>
						</form>
					</div>
				</div>
				@else
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Tambah Data Penelitian Mahasiswa</h3>
						<span class="text-grey">These are the basic bootstrap form elements</span>
					</div>
					<div class="panel-body">
						<form action="{{ route('penelitian.store') }}" class="group-border-dashed" method="post">
						{{ csrf_field() }}
							<div class="col-md-12">
								<div class="form-group">
									<label>Judul Skripsi</label>
									<input class="form-control" type="text" name="judul" placeholder="Masukkan judul penelitian" required="">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Nama Peneliti</label>
									<input class="form-control" type="text" name="penulis" placeholder="Masukkan nama peneliti" required="">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Tanggal</label>
									<input class="form-control" type="date" name="date" placeholder="Masukkan tanggal penelitian" required="">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Fakultas</label>
									<select class="form-control" id="fakultas" name="idFakultas" required="">
										<option data-tokens="" value="">- Pilih Fakultas -</option>
										<option data-divider="true"></option>
										@foreach($data['fakultas'] as $fakultas)
										<option value="{{$fakultas->idFakultas}}" >{{$fakultas->namaFakultas}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Keywords</label>
									<input class="form-control" type="text" name="keywords" placeholder="Pisahkan setiap keyword dengan ;. Contoh= er; ihjnk" required="">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Abstrak</label>
									<textarea name="abstrak" class="form-control"></textarea>
								</div>
							</div>
							<div class="col-md-12">
							<button type="submit" class="btn btn-primary break-bottom-10 pull-right">Simpan</button>
							</div>
						</form>
					</div>
				</div>
				 @endif
				
			</div>
		</div>
	</div>
</div>

@endsection