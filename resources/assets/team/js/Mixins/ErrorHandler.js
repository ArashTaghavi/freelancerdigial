import Swal from 'sweetalert2/dist/sweetalert2.all.min';

export default {
    data() {
        return {
            formErrors: {}
        };
    },
    methods: {
        hasFieldError(field) {
            return this.formErrors.hasOwnProperty(field);
        },
        recordFieldErrors(errors) {
            try {
                this.formErrors = errors;
            } catch (e) {
                //
            }
        },
        getFieldError(field) {
            if (this.formErrors[field]) {
                return this.formErrors[field][0];
            }
        },
        clearFieldError(field) {
            if (this.formErrors[field]) {
                let vm = this;
                Vue.nextTick(function () {
                    vm.formErrors[field] = [''];
                    delete vm.formErrors[field];
                });
            }
        },
        resetFieldErrors() {
            this.formErrors = {};
        },
        anyFieldErrors() {
            return Object.keys(this.formErrors).length > 0;
        },
        notifyFieldErrors() {
            try {
                let error_message = '<ul class="text-right" style="padding: 0 10px;">';
                for (let error in this.formErrors) {
                    error_message += "<li>" + this.formErrors[error][0] + "</li>";
                }
                error_message += '</ul>';
                swal({
                    title: 'پیام سیستم',
                    html: error_message,
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#777',
                    confirmButtonText: 'تایید'
                });
                //this.notifyErrorMessage(error_message);
                // this.notifyRawMessage(error_message, type);
                // swal('پیام سیستم', error_message, 'error');
            } catch (e) {
                //
            }
        },
        notifyResponse(response) {
            try {
                if (response.status === 413) {
                    this.notifyMessage('خطا در بارگذاری، لطفاً مجدداً تلاش نمائید.', type);
                } else {
                    let message = response.data.message;
                    let type = 'error';
                    if (response.status === 200) {
                        type = 'success';
                    }
                    this.notifyMessage(message, type);
                }
            } catch (e) {
                //
            }
        },
        responseHasError(error) {
            return error.response.data.hasOwnProperty('errors');
        },
        successNotify(message) {
            Swal.fire({
                title: message,
                type: 'success',
                icon:'success',
                timer: 2000,
            });
        },
        errorNotify(message) {
            iziToast.error({
                message: message,
                rtl: true
            });
        },
        saveMessage(response, type = 'success') {
            swal({
                title: response,
                text: '',
                type: type,
                showConfirmButton: false,
                background: 'rgba(0, 0, 0, 0.96)',
                timer: 3000,
            });
        },

    }
}
