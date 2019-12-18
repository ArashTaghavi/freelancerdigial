import Swal from 'sweetalert2';

export default {
    data() {
        return {
            loading: false,
            datePickerColor: '#489CB3'
        };
    },
    methods: {
        deleteConfirm() {
            return new Promise(
                function (resolve, reject) {
                    Swal.fire({
                        title: 'آیا مطمین هستید؟',
                        //text: "You won't be able to revert this!",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'خیر',
                        confirmButtonText: 'بله، حذف شود!',
                        icon:'warning',
                    }).then(confirm => {
                        if (confirm.value) {
                            resolve(confirm);
                        } else {
                        }
                    }).catch(error => {
                        reject(false);
                    });
                }
            );
        },
        operationConfirm() {
            return new Promise(
                function (resolve, reject) {
                    Swal.fire({
                        title: 'آیا مطمین هستید؟',
                        //text: "You won't be able to revert this!",
                        type: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'خیر',
                        confirmButtonText: 'بله!'
                    }).then(confirm => {
                        if (confirm.value) {
                            resolve(confirm);
                        } else {
                        }
                    }).catch(error => {
                        reject(false);
                    });
                }
            );
        },
        notifyMessage(message) {
            Swal.fire({
                title: message,
                //text: "You won't be able to revert this!",
                icon:'success',
            });
        },
        notifyRawMessage(message, type = 'error') {
            Swal.fire({
                title: message,
                //text: "You won't be able to revert this!",
                icon:'error',
            });
        },
        notifySuccessMessage(message) {
            swal({
                title: 'پیام سیستم',
                text: message,
                type: 'success',
                showCancelButton: false,
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-sm btn-light',
                background: 'rgba(0, 0, 0, 0.96)',
                confirmButtonText: 'تایید'
            });
        },
        notifyErrorMessage(message) {
            swal({
                title: 'پیام سیستم',
                text: message,
                type: 'error',
                showCancelButton: false,
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-sm btn-light',
                background: 'rgba(0, 0, 0, 0.96)',
                confirmButtonText: 'تایید'
            });
        },
        scrollToTop() {
            window.scroll({
                top: 0,
                left: 0,
                behavior: 'smooth'
            });
        },
        scrollToElement(selector) {
            $('html, body').animate({
                scrollTop: ($(`${selector}`).offset().top)
            }, 500);
        }
    },
    mounted() {
        //this.scrollToTop();
    }
}
