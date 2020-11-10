/**
 * Created by Jonathan on 05/10/2016.
 */
$(document).ready(function () {
    toastr.options = {
        "closeButton": false, "debug": false, "newestOnTop": false, "progressBar": true,
        "positionClass": "toast-bottom-right", "preventDuplicates": true, "showDuration": "300", "hideDuration": "1000",
        "timeOut": "5000", "extendedTimeOut": "1000", "showEasing": "swing", "hideEasing": "linear",
        "showMethod": "slideDown", "hideMethod": "slideUp"
    };

    if (typeof swal !== 'undefined') {
        swal.setDefaults({
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar"
        });
    }
});
