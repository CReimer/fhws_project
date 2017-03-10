Polymer({
    is: 'app-my-items',
    properties: {
        projects: {
            type: Object
        },
        headers: {
            type: Object,
            computed: '_computeHeaders()'
        }
    },
    _computeHeaders: function () {
        return {
            'Authorization': "Bearer " + jwt_token
        };
    },

    ready: function () {
        // this.$.requestUserProjects.generateRequest();
    },
    handleResponse: function (data) {
        console.log(data.detail.response);
        this.projects = data.detail.response;
    }
});