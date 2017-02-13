/**
 * Created by christopher on 13.02.17.
 */
Polymer({
    is: 'app-detail',
    properties: {
        route: {
            type: Object,
            notify: true
        },
        project: {
            type: Object
        }
    },
    ready: function() {
        this.$.requestProjectById.url = this.$.requestProjectById.url + '/' + this.route.path.replace(/\//g,'');
        this.$.requestProjectById.generateRequest();
    },
    handleResponse: function(data) {
        // console.log(data.detail.response);
        this.project = data.detail.response;
    }
});