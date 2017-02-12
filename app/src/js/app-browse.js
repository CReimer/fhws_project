/**
 * Created by christopher on 09.02.17.
 */

Polymer({
    is: 'app-browse',
    properties: {
        projects: {
            type: Object
        }
    },
    ready: function() {
        this.$.requestProjects.generateRequest();
    },
    handleResponse: function(data) {
        console.log(data.detail.response);
        this.projects = data.detail.response;
    }
});

