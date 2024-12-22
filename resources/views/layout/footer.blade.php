<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/21/2024
 */

?>

    <!-- Start Footer -->
<footer>

</footer>
<!-- End Footer -->

<!-- Start Script -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>
<script src="{{ asset('assets/javascript/popper.min.js') }}"></script>
<script src="{{ asset('assets/javascript/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/javascript/toastr.min.js') }}"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>

<script>
    function deleteAll() {
        localStorage.removeItem("access_token");
        localStorage.removeItem("username");
    }
</script>

@stack('scripts')
</body>
</html>
