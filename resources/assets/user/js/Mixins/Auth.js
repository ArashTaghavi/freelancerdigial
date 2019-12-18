export default {
    data() {
        return {
            SUPERADMIN: []
        }
    },
    methods: {
        hasAccess(permissionName) {
            if (Array.isArray(permissionName)) {
                let result = false;
                permissionName.forEach(item => {
                    if (this.checkPermission(item)) {
                        result = true;
                    }
                });
                return result;
            } else {
                return this.checkPermission(permissionName);
            }
        },
        hasAccessWithParams(permissionName, params) {
            return this.checkPermission(permissionName, params);
        },
        checkPermission(permissionName, params = []) {

            let _allPermissions = JSON.parse(localStorage.getItem('allPermissions'));
            let _userPermissions = JSON.parse(localStorage.getItem('userPermissions'));
            let _isSuperAdmin = JSON.parse(localStorage.getItem('isSuperAdmin'));
            if (_isSuperAdmin)
                return true;

            let pIndex = _allPermissions.findIndex(permission => permission.name === permissionName);

            if (pIndex === -1) {
                return true;
            }

            let user_permission = _userPermissions[_allPermissions[pIndex].id];
            if (user_permission === undefined) {
                return false;
            }
            return true;
        },
        hasAccessToRoute(routeName) {
            let resolved = this.$router.resolve(routeName);
            if (resolved.route.name !== '404') {
                if (resolved.route.meta.hasOwnProperty('permission')) {
                    return this.hasAccess(resolved.route.meta.permission);
                }
            }
            return true;
        },
        canPublish(contentType) {
            if (Array.isArray(contentType)) {
                let result = false;
                contentType.forEach(item => {
                    if (this.hasAccess('publish-' + item)) {
                        result = true;
                    }
                });
                return result;
            } else {
                return this.hasAccess('publish-' + contentType);
            }
        },
        initPublishFlag(contentType) {
            if (!this.hasAccess('publish-' + contentType)) {
                if (this.form.hasOwnProperty('is_published')) {
                    delete this.form.is_published;
                }
            }
        },
        getPersonTooltip(person) {
            return this.hasAccess('view-mobile-in-message') ? person.mobile_number : `${person.first_name} ${person.last_name}`;
        },
        hasProfile() {
            return true;
            // return JSON.parse(localStorage.getItem('hasProfile'));
        },
        isSuperAdmin() {
            axios.get('/users/is-admin').then(response => this.SUPERADMIN = response.data);
            return this.SUPERADMIN;
        }
    }
}