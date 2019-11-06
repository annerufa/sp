<?php $__env->startSection('content'); ?>

<div id="content">
	<div class="container-fluid">
		<?php if(Session::has('success')): ?>
		<div class="alert alert-success fade in" id="success-alert">
			<?php echo e(Session::get('success')); ?>

		</div>
		<?php endif; ?>
		<div class="row">
			<div class="col-xs-12 col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<span class="panel-title pull-left text-black"><i class="fa fa-fw fa-book"></i>Tabel Penelitian Mahasiswa </span>
						<!-- Add Button -->
						<div class="btn-group btn-group-sm pull-right" role="group">
							<a href="<?php echo e(route('penelitian.create')); ?>" class="btn btn-floyd break-bottom-10" ><i class="fa fa-fw fa-plus"></i> <span class="hidden-sm">Tambah</span></a>
						</div>

						<div class="clearfix"></div>

					</div>

					<div class="panel-body table-responsive table-full">
						<table id="example" class="table table-striped table-bordered" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Judul</th>
									<th class="text-center">Tahun</th>
									<th class="text-center">Aksi</th>
								</tr>
							</thead>

							<tbody>
								<?php $__currentLoopData = $data['dok']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $no=>$k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td width="5%" scope="row"><?php echo e(++$no); ?></td>
									<td width="47%" ><?php echo e($k->judul); ?></td>
									<td width="30%"><?php echo e($k->penulis); ?></td> 
									<td width="18%">
										<form action="<?php echo e(route('penelitian.destroy',$k->idDok)); ?>" method="POST">
											<a class="btn btn-sm btn-success" href="<?php echo e(route('penelitian.show',$k->idDok)); ?>"><i class='fa fa-search'></i></a>
											<a class="btn btn-sm btn-warning" href="<?php echo e(route('penelitian.edit',$k->idDok)); ?>"><i class='fa fa-edit'></i></a>
											<?php echo csrf_field(); ?>
											<?php echo method_field('DELETE'); ?>
											<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus dokumen?')"><i class='fa fa-trash'></i></button>
										</form>
										
										<!--  <?php if($k->hasilPre==NULL): ?>
										 <a href="/preproses/<?php echo e($k->idDok); ?>" style="margin-left: 5px;" class="btn btn-sm btn-info">Pre</a>
										 <?php else: ?>
										 <a href="/preproses/<?php echo e($k->idDok); ?>" style="margin-left: 5px;" class="btn btn-sm btn-warning">Done</a>
										 <?php endif; ?> -->
									</td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\template2\resources\views/dokumen.blade.php ENDPATH**/ ?>