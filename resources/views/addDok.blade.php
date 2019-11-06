@extends('navbar')
@section('content')

<div id="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Basic Elements</h3>
						<span class="text-grey">These are the basic bootstrap form elements</span>
					</div>
					<div class="panel-body">
						<form action="{{ route('dok.store') }}" class="group-border-dashed" method="post">
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
									<input class="form-control" type="date" name="tgl" placeholder="Masukkan tanggal penelitian" required="">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Fakultas</label>
									<select class="form-control" id="fakultas" name="fakultas" required="">
										<option data-tokens="" value="">- Pilih Fakultas -</option>
										<option data-divider="true"></option>
										<option >Fakultas A</option>
										<option >Fakultas B</option>
										<option >Fakultas C</option>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Keyword</label>
									<input class="form-control" type="text" name="judul" placeholder="Pisahkan setiap keyword dengan ;. Contoh= er; ihjnk" required="">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Abstrak</label>
									<textarea class="form-control"></textarea>
								</div>
							</div>
							<div class="col-md-12">
							<button type="submit" class="btn btn-primary break-bottom-10 pull-right">Simpan</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection