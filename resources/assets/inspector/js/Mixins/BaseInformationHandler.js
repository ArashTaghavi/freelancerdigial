export default {
    data() {
        return {
            categories: [],
            content_category_ids: [],
            languages: [],
            positions: [],
            slider_positions: [],
            block_positions: [],
            menu_positions: [],
            tip_pages: []
        }
    },
    methods: {
        getLanguagesListed() {
            axios.get('/base/languages')
                .then(response => {
                    this.languages = response.data;
                })
                .catch(error => {
                });
        },
        getSliderCategoriesByLanguage(language_id) {
            axios.get(`/slider-categories/select/${language_id}`)
                .then(response => {
                    this.categories = response.data;
                });
        },
        setSliderCategoriesWatcher() {
            this.$watch('form.language_id', function (newValue) {
                this.form.slider_category_id = null;
                this.getSliderCategoriesByLanguage(newValue);
            });
        },
        setSliderPositionsWatcher() {
            this.$watch('form.language_id', function (newValue) {
                this.form.slider_position_id = null;
                this.getSliderPositionsByLanguage(newValue);
            });
        },
        getSliderPositionsByLanguage(language_id) {
            axios.get(`/sliders/positions/${language_id}`)
                .then(response => this.slider_positions = response.data)
                .catch(exception => this.notifyResponse(exception.response));
        },
        getReportCategoriesByLanguage(language_id) {
            axios.get(`/report-categories/select/${language_id}`)
                .then(response => {
                    this.categories = response.data;
                });
        },
        setReportCategoriesWatcher() {
            this.$watch('form.language_id', function (newValue) {
                this.form.report_category_id = null;
                this.getReportCategoriesByLanguage(newValue);
            });
        },
        getVideoCategoriesByLanguage(language_id) {
            axios.get(`/video-categories/select/${language_id}`)
                .then(response => {
                    this.categories = response.data;
                });
        },
        setVideoCategoriesWatcher() {
            this.$watch('form.language_id', function (newValue) {
                this.form.category = [];
                this.getVideoCategoriesByLanguage(newValue);
            });
        },
        getTipPages() {
            axios.get('/tips/positions')
                .then(response => this.positions = response.data)
                .catch(exception => this.notifyResponse(exception.response));
        },
        setTipPagesWatcher() {
            this.$watch('form.language_id', function (newValue) {
                this.form.tip_page_id = null;
                this.getTipPagesByLanguage(newValue);
            });
        },
        getTipPagesByLanguage(language_id) {
            axios.get(`/tip-pages/select/${language_id}`).then(response => this.tip_pages = response.data);
        },
        getTipCategoriesByLanguage(language_id) {
            axios.get(`/tip-categories/select/${language_id}`).then(response => this.categories = response.data);
        },
        setTipCategoriesWatcher() {
            this.$watch('form.language_id', function (newValue) {
                this.form.tip_category_id = [];
                this.getTipCategoriesByLanguage(newValue);
            });
        },
        getDocumentCategoriesByLanguage(language_id) {
            axios.get(`/document-categories/select/${language_id}`).then(response => this.categories = response.data);
        },
        setDocumentCategoriesWatcher() {
            this.$watch('form.language_id', function (newValue) {
                this.form.document_category_ids = [];
                this.getDocumentCategoriesByLanguage(newValue);
            });
        },
        getPspDocumentCategoriesByLanguage(language_id) {
            axios.get(`/psp-document-categories/select/${language_id}`)
                .then(response => {
                    this.categories = response.data;
                });
        },
        setPspDocumentCategoriesWatcher() {
            this.$watch('form.language_id', function (newValue) {
                this.form.psp_document_category_ids = [];
                this.getPspDocumentCategoriesByLanguage(newValue);
            });
        },
        getPhDocumentCategoriesByLanguage(language_id) {
            axios.get(`/ph-document-categories/select/${language_id}`)
                .then(response => {
                    this.categories = response.data;
                });
        },
        setPhDocumentCategoriesWatcher() {
            this.$watch('form.language_id', function (newValue) {
                this.form.ph_document_category_ids = [];
                this.getPhDocumentCategoriesByLanguage(newValue);
            });
        },
        getLinkCategoriesByLanguage(language_id) {
            axios.get(`/link-categories/select/${language_id}`)
                .then(response => {
                    this.categories = response.data;
                });
        },
        setLinkCategoriesWatcher() {
            this.$watch('form.language_id', function (newValue) {
                this.form.link_category_id = null;
                this.getLinkCategoriesByLanguage(newValue);
            });
        },
        getBlockPositionsByLanguage(language_id) {
            axios.get(`/blocks/positions/${language_id}`).then(response => this.block_positions = response.data);
        },
        setBlockPositionsWatcher() {
            this.$watch('form.language_id', function (newValue) {
                this.form.block_position_id = null;
                this.getBlockPositionsByLanguage(newValue);
            });
        },

        getMenuPositionsByLanguage(language_id) {
            axios.get(`/menus/positions/${language_id}`).then(response => this.menu_positions = response.data);
        },
        setMenuPositionsWatcher() {
            this.$watch('form.language_id', function (newValue) {
                this.form.menu_position_id = null;
                this.getMenuPositionsByLanguage(newValue);
            });
        },
        
    },
}
