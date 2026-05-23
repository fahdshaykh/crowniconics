  <!--bootstrap js-->
  <script src="{{ asset('dashboard/assets')}}/js/bootstrap.bundle.min.js"></script>

  <!--plugins-->
  <script src="{{ asset('dashboard/assets')}}/js/jquery.min.js"></script>
  <!--plugins-->
  <script src="{{ asset('dashboard/assets')}}/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
  <script src="{{ asset('dashboard/assets')}}/plugins/metismenu/metisMenu.min.js"></script>
  <script src="{{ asset('dashboard/assets')}}/plugins/apexchart/apexcharts.min.js"></script>
  <script src="{{ asset('dashboard/assets')}}/plugins/simplebar/js/simplebar.min.js"></script>
  <script src="{{ asset('dashboard/assets')}}/plugins/peity/jquery.peity.min.js"></script>
  <script src="{{ asset('dashboard/assets')}}/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('dashboard/assets')}}/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(".data-attributes span").peity("donut")
  </script>
  <script src="{{ asset('dashboard/assets')}}/js/main.js"></script>
  <script src="{{ asset('dashboard/assets')}}/js/dashboard1.js"></script>
  <script>
	   new PerfectScrollbar(".user-list")
  </script>
  <script>
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>

<script>
  $(document).ready(function() {
    var table = $('#example2').DataTable({
      lengthChange: false,
      buttons: ['copy', 'excel', 'pdf', 'print']
    });
  
    table.buttons().container()
      .appendTo('#example2_wrapper .col-md-6:eq(0)');
  });
</script>


</body>

</html>