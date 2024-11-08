

<script src="{{asset('backend')}}/app-assets/vendors/js/vendors.min.js"></script>
<script src="{{asset('backend')}}/app-assets/vendors/js/charts/apexcharts.min.js"></script>
<script src="{{asset('backend')}}/app-assets/js/core/app-menu.js"></script>
<script src="{{asset('backend')}}/app-assets/js/core/app.js"></script>
<script src="{{asset('backend')}}/app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>

<script src="{{asset('backend')}}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="{{asset('backend')}}/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<script src="{{asset('backend')}}/app-assets/vendors/js/extensions/dropzone.min.js"></script>
<script src="{{asset('backend')}}/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
<script src="{{asset('backend')}}/app-assets/js/scripts/pages/page-account-settings.js"></script>
<script src="{{ asset('') }}backend/app-assets/js/scripts/forms/form-select2.js"></script>

<!-- Datatable -->
<script src="{{ asset('') }}backend/app-assets/vendors/js/extensions/moment.min.js"></script>
<script src="{{ asset('') }}backend/custom/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('') }}backend/custom/datatable/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('') }}backend/custom/datatable/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('') }}backend/custom/datatable/js/responsive.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>


<!-- Toaster -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
    @if(Session::has('message'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
    toastr.success("{{ session('message') }}");
    @endif
        @if(Session::has('error'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
    toastr.error("{{ session('error') }}");
    @endif
        @if(Session::has('info'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
    toastr.info("{{ session('info') }}");
    @endif
        @if(Session::has('warning'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
    toastr.warning("{{ session('warning') }}");
    @endif
</script>

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>


 <!-- bootbox cdn link -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.1/bootbox.min.js"></script>

 <script>
     $(document).on("click" , "#delete" , function(e){
         e.preventDefault();
         var link = $(this).attr("href");
         bootbox.confirm("Are you want to delete!!", function(confirmed){
             if(confirmed){
                 window.location.href = link;
             };
         });
     });
 </script>
