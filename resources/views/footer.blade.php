</div>
	</div>
</body>

<script src="{{ URL::asset('assets/plugins/jquery/jquery-3.1.1.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.css')}}" />
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/theme-floyd.js')}}"></script>
<!-- <script src="{{ URL::asset('assets/plugins/jquery/jquery-3.1.1.min.js')}}"></script> -->
<!-- <script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
	<script src="../assets/plugins/datatable/dataTables.bootstrap.min.js"></script> -->

	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		} );
	</script>
	<script>
		$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
			$("#success-alert").slideUp(500);
		});

	</script>
	<script src="{{ URL::asset('assets/js/theme-floyd.js')}}"></script>
	</html>