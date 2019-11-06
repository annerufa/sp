<?php $__env->startSection('content'); ?>

<div id="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<span class="panel-title pull-left text-black"><i class="fa fa-fw fa-users"></i> Tabel Kata Unik </span>
						<!-- Add Button -->
						<div class="btn-group btn-group-sm pull-right" role="group">
							<a href="<?php echo e(route('tfidf')); ?>" class="btn btn-success break-bottom-10" ><i class="fa fa-fw fa-plus"></i> <span class="hidden-sm">Hitung Bobot Kata</span></a>
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
								<?php $__currentLoopData = $data['kata']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $no=>$k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td scope="row"><?php echo e(++$no); ?></td>
									<td><?php echo e($k->kata); ?></td>
									<td><?php echo e($k->totDok); ?> dokumen</td>
									<td><?php echo e($k->idf); ?></td>
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
<?php echo $__env->make('navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\template2\resources\views/kata.blade.php ENDPATH**/ ?>