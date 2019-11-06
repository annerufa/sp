<?php $__env->startSection('content'); ?>

<div id="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php if($data['status']=='edit'): ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Ubah Data Penelitian Mahasiswa</h3>
						<span class="text-grey">These are the basic subtitle form elements</span>
					</div>
					<div class="panel-body">
						<form action="<?php echo e(route('penelitian.update' , $data['dokumen']->idDok )); ?>" class="group-border-dashed" method="post">
						<input type="hidden" name="_method" value="PUT">
						<?php echo e(csrf_field()); ?>

							<div class="col-md-12">
								<div class="form-group">
									<label>Judul Skripsi</label>
									<input class="form-control" type="text" name="judul" value="<?php echo e($data['dokumen']->judul); ?>"  placeholder="Masukkan judul penelitian" required="">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Nama Peneliti</label>
									<input class="form-control" type="text" name="penulis" value="<?php echo e($data['dokumen']->penulis); ?>"  placeholder="Masukkan nama peneliti" required="">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Tanggal</label>
									<input class="form-control" type="date" name="date" value="<?php echo e($data['dokumen']->date); ?>" required="">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Fakultas</label>
									<select class="form-control" id="fakultas" name="idFakultas" required="">
										<option data-tokens="" value="">- Pilih Fakultas -</option>
										<option data-divider="true"></option>
										<?php $__currentLoopData = $data['fakultas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($f->idFakultas); ?>" <?php echo e($f->idFakultas == $data['dokumen']->idFakultas? 'selected' : ''); ?>><?php echo e($f->namaFakultas); ?></option>

										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Keywords</label>
									<input class="form-control" type="text" name="keywords"value="<?php echo e($data['dokumen']->keywords); ?>" required="">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Abstrak</label>
									<textarea name="abstrak" class="form-control"><?php echo e($data['dokumen']->abstrak); ?>"</textarea>
								</div>
							</div>
							<div class="col-md-12">
							<button type="submit" class="btn btn-primary break-bottom-10 pull-right">Simpan</button>
							</div>
						</form>
					</div>
				</div>
				<?php else: ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Tambah Data Penelitian Mahasiswa</h3>
						<span class="text-grey">These are the basic bootstrap form elements</span>
					</div>
					<div class="panel-body">
						<form action="<?php echo e(route('penelitian.store')); ?>" class="group-border-dashed" method="post">
						<?php echo e(csrf_field()); ?>

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
										<?php $__currentLoopData = $data['fakultas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fakultas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($fakultas->idFakultas); ?>" ><?php echo e($fakultas->namaFakultas); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
				 <?php endif; ?>
				
			</div>
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\template2\resources\views/formPenelitian.blade.php ENDPATH**/ ?>