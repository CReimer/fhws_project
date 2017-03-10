Polymer({
    is: 'app-main',

    properties: {
        page: {
            type: String,
            reflectToAttribute: true,
            observer: '_pageChanged'
        },

        route: Object,

        subroute: Object,

        routeData: Object
    },

    toggleLoginDialog: function () {
        this.$.loginDialog.toggle();
    },

    observers: [
        '_routePageChanged(routeData.page)'
    ],

    _routePageChanged: function (page) {
        this.page = page || 'home';

        if (!this.$.drawer.persistent) {
            this.$.drawer.close();
        }
    },

    _pageChanged: function (page) {
        var resolvedPageUrl = this.resolveUrl('app-' + page + '.html');
        this.importHref(resolvedPageUrl, null, this._showPage404, true);
    },

    _showPage404: function () {
        this.page = 'error404';
    },
    handleResponse: function (data) {
        console.log("response", data)
    },
    loginSubmit: function () {
        loginSubmit(this.$.loginform.getElementsByClassName('k-number')[0].value, this.$.loginform.getElementsByClassName('password')[0].value);
        this.$.loginDialog.toggle();
    }
});
