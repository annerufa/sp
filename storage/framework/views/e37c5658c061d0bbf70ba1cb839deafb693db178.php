<?php $__env->startSection('content'); ?>

<div id="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Detail Data Penelitian Mahasiswa</h3>
						<span class="text-grey">These are the basic subtitle form elements</span>
					</div>
					<div class="panel-body">
                        <div class="col-sm-12">
                            <table class="table tbl-detail">
                                <tr>
                                    <td width="150px;">Judul</td>
                                    <td>: <?php echo e($dokumen->judul); ?></td>
                                </tr>
                                <tr>
                                    <td>Penulis</td>
                                    <td>: <?php echo e($dokumen->penulis); ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal </td>
                                    <td>: <?php echo e(date('d M Y', strtotime($dokumen->date))); ?></td>
                                </tr>
                                <tr>
                                    <td>Fakultas</td>
                                    <td>: <?php echo e($dokumen->fakultas->namaFakultas); ?></td>
                                </tr>
                                <tr>
                                    <td>Keywords</td>
                                    <td>: <?php echo e($dokumen->keywords); ?></td>
                                </tr>
                                <tr>
                                    <td>Abstrak</td>
                                    <td>: <?php echo e($dokumen->abstrak); ?></td>
                                </tr>
                                <tr>
                                    <td>Hasil Pre-processing</td>
                                    <td>: <?php echo e($dokumen->hasilPre); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\template2\resources\views/viewPenelitian.blade.php ENDPATH**/ ?>