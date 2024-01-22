function renderSweetAlert(options) {
    if (typeof options === 'object') {

        Swal.fire({
            title: options.hasOwnProperty('title') ? options.title : 'Are you sure?',
            text: options.hasOwnProperty('text') ? options.text : "You won't be able to revert this!",
            type: options.hasOwnProperty('type') ? options.type : "question",
            showCancelButton: options.hasOwnProperty('showCancelButton') ? options.showCancelButton : true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: options.hasOwnProperty('confirmButtonText') ? options.confirmButtonText : "Yes, delete it!",
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-danger ml-1",
            buttonsStyling: false,
            showLoaderOnConfirm: true,
            preConfirm: function (login) {
                return $.ajax({
                    url: options.ajax.url,
                    method: options.ajax.method,
                    data: options.ajax.data ? options.ajax.data : {},
                    success: function (data) {
                        return data;
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        Swal.fire({
                            title: textStatus.toUpperCase(),
                            text: errorThrown,
                            type: 'error'
                        })
                     }
                })
            },
            allowOutsideClick: function () {
                !Swal.isLoading();
            }
        }).then(function (result) {
            if(result.dismiss === Swal.DismissReason.cancel) {
                return; 
            } 
            
            if (result.value.status) {
                Swal.fire({
                    title: 'Success',
                    text: result.value.message ?? '',
                    type: 'success'
                }).then(res => {
                    if(options.hasOwnProperty('onRunFunction')) {
                        options.onRunFunction()
                    } else {
                        location.reload();
                    }
                })
            } else {
                Swal.fire({
                    title: 'FAILED',
                    text: result.value.message ?? '',
                    type: 'warning'
                })
            }

            
        });

    } else {
        Swal.fire({
            title: 'Oops! Failed :<',
            text: 'Something went wrong! Contact customer service to check this issue.',
            type: 'error'
        })
    }
}