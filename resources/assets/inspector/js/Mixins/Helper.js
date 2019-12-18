export default {
    data() {
        return {
            form: {
                tags: [],
                category: [],
                image: null,
                content_category_ids: []
            },
            label_types: [
                {id: 'badge badge-pill badge-primary', title: 'آبی تیره'},
                {id: 'badge badge-pill badge-info', title: 'آبی روشن'},
                {id: 'badge badge-pill badge-danger', title: 'قرمز'},
                {id: 'badge badge-pill badge-secondary', title: 'سفید'},
                {id: 'badge badge-pill badge-success', title: 'سبز'},
                {id: 'badge badge-pill badge-warning', title: 'زرد'}
            ],
            breadcrumb: [],
            headerText: null,
            cropperKey: '',
            gRecaptchaSiteKey: '',
            displayName: '',
            profilePic: null,
            rolesName: '',
            showForm: false,
            imageTooltipTemplate: '<div class="tooltip image-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        };
    },
    updated() {
        this.cleanTooltips();
    },
    methods: {
        getAuthToken() {
            return this.$auth.token();
        },
        getFormFromResponse(response) {
            this.form = response.data;
        },
        getTagsFromResponse(response) {
            let fetchedTags = response.data.tags;
            this.form.tags = [];
            try {
                for (let index in fetchedTags) {
                    this.form.tags.push({text: fetchedTags[index].name});
                }
            } catch (e) {
                //
            }
        },
        getCategoriesFromResponse(response) {
            this.form.category = [];
            try {
                for (let index in response.data.categories) {
                    this.form.category.push(response.data.categories[index].id);
                }
            } catch (e) {
                //
            }
        },
        getSystemName() {
            let setting = localStorage.getItem('system_name');
            return setting;
        },
        getSystemFooterText() {
            let setting = JSON.parse(localStorage.getItem('footer_text'));
            return setting;
        },
        cleanTooltips() {
            $('.tooltip, [rel="tooltip"]').tooltip('hide');
        },
        trimChar(string, charToRemove) {
            while (string.charAt(0) == charToRemove) {
                string = string.substring(1);
            }

            while (string.charAt(string.length - 1) == charToRemove) {
                string = string.substring(0, string.length - 1);
            }

            return string;
        },
        formatTimer(days, hours, minutes, seconds) {
            let daySuffix = 'روز', hourSuffix = 'ساعت', minuteSuffix = 'دقیقه', secondSuffix = 'ثانیه';
            let result = '';
            if (days > 0) {
                result += `${days} ${daySuffix} `;
            }
            if (hours > 0) {
                result += `${hours} ${hourSuffix} `;
            }
            if (minutes > 0) {
                result += `${minutes} ${minuteSuffix} `;
            }
            result += `${seconds} ${secondSuffix}`;
            return result;
        },
        setState(key, value) {
            localStorage.setItem(key, JSON.stringify(value));
        },
        getState(key) {
            return JSON.parse(localStorage.getItem(key));
        },
        getLoaderContent() {
            return '<div style="margin: 0 auto" class="page-loader__spinner"><svg viewBox="25 25 50 50"><circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>';
        },
        getCurrentTimestamp() {
            return Math.round((new Date()).getTime() / 1000);
        },
        updateLinkableType(linkableType) {
            this.form.linkable_type = linkableType;
        },
        updateLinkableId(linkableId) {
            this.form.linkable_id = linkableId;
        },
        enableForm() {
            this.showForm = true;
        }
    }

}
