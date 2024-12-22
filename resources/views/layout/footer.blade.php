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
<script src="{{ asset('assets/javascript/common.js') }}"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
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

    function logoutAndRedirect() {
        deleteAll();
        window.location.href = "{{ route('login') }}";
    }

    function loginUrl() {
        window.location.href = "{{ route('login') }}";
    }

    function home() {
        window.location.href = "{{ route('home') }}";
    }


    function taskListUrl(){
        return "{{ route('api.tasks.index') }}";
    }

    function logoutUrl(){
        return "{{ route('api.logout') }}";
    }

    function taskCreateUrl(){
        return "{{ route('api.tasks.store') }}";
    }

    function taskUpdateUrl(id){
        return "{{ route('api.tasks.update', ':id') }}".replace(':id', id);
    }

    function taskDeleteUrl(id){
        return "{{ route('api.tasks.destroy', ':id') }}".replace(':id', id);
    }

    function taskShowUrl(id){
        return "{{ route('api.tasks.show', ':id') }}".replace(':id', id);
    }
</script>

@stack('scripts')
</body>
</html>
