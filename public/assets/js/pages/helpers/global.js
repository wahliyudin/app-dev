const handleErrors = (jqXHR, selector = '') => {
    $(selector).hide();
    if (jqXHR.status === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Not connect.\n Verify Network.',
        })
    } else if (jqXHR.status == 400) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: jqXHR['responseJSON'].message,
        })
    } else if (jqXHR.status == 419) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: 'Oops!. Session anda sudah habis, silahkan login kembali!',
        }).then(function () {
            window.location = '/login';
        });
    } else if (jqXHR.status == 404) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Requested page not found. [404]',
        })
    } else if (jqXHR.status == 500) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Internal Server Error [500].' + jqXHR['responseJSON']?.message,
        })
    } else if (jqXHR.status == 422) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: JSON.parse(jqXHR.responseText).message,
        })
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: jqXHR.responseText,
        })
    }
}
export { handleErrors }
