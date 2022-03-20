
<!-- Bootstrap 3.3.7 -->
{{ Html::script('public/assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}

{{ Html::script('public/assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}


{{ Html::script('public/assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}

{{ Html::script('public/assets/bower_components/responsive-datatable/dataTables.responsive.min.js') }}
<!-- Will include JS files when needed only -->
@yield('extra-js')

<!-- Select2 -->
{{ Html::script('public/assets/bower_components/select2/dist/js/select2.full.min.js') }}
<!-- InputMask -->
{{ Html::script('public/assets/plugins/input-mask/jquery.inputmask.js') }}

{{ Html::script('public/assets/plugins/input-mask/jquery.inputmask.date.extensions.js') }}
{{ Html::script('public/assets/plugins/input-mask/jquery.inputmask.extensions.js') }}
<!-- date-range-picker -->
{{ Html::script('public/assets/bower_components/moment/min/moment.min.js') }}

{{ Html::script('public/assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}
<!-- bootstrap datepicker -->

{{ Html::script('public/assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}
<!-- bootstrap color picker -->
{{ Html::script('public/assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}
<!-- bootstrap time picker -->
{{ Html::script('public/assets/plugins/timepicker/bootstrap-timepicker.min.js') }}
<!-- SlimScroll -->
{{ Html::script('public/assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}
<!-- iCheck 1.0.1 -->
{{ Html::script('public/assets/plugins/iCheck/icheck.min.js') }}
<!-- FastClick -->
{{ Html::script('public/assets/bower_components/fastclick/lib/fastclick.js') }}
<!-- AdminLTE App -->
{{ Html::script('public/assets/dist/js/adminlte.min.js') }}
<!-- AdminLTE for demo purposes -->
{{ Html::script('public/assets/dist/js/demo.js') }}
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2();

    $('.datepicker').datepicker({
      autoclose: true,
      format: "yyyy-mm-dd"
    });

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' });
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    );

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    });

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    });
  });
</script>
</body>
</html>
