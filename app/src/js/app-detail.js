Polymer({
    is: 'app-detail',
    properties: {
        route: {
            type: Object,
            notify: true
        },
        project: {
            type: Object
        },
        data: {
            type: Object
        }
    },

    toggleDeleteDialog: function () {
        var dialog = document.querySelector("#deleteDialog");
        var yb = dialog.querySelector("#yesbtn");
        var nb = dialog.querySelector("#nobtn");
        yb.addEventListener("click", this.deleteItem);
        nb.addEventListener("click", this.closeDeleteAlert);
        dialog.open();
    },

    closeDeleteAlert: function () {
        var dialog = document.querySelector("#deleteDialog");
        dialog.close();
    },

    deleteItem: function () {

        var id = this.baseURI.split('/').pop();

        var xhr = new XMLHttpRequest();
        xhr.open("DELETE", "../api_v1/index.php/projects/" + id);
        xhr.setRequestHeader("Authorization", "Bearer " + jwt_token);
        xhr.send();

        var dialog = document.querySelector("#deleteDialog");
        dialog.close();

    },

    observers: [
        '_viewChanged(routeData)'
    ],

    _viewChanged: function(routeData) {
        var courseId = routeData.course_id;
        if(!courseId) {
            var loc = window.location.pathname;
            var components = loc.split("/");
            if(components.length !== 3 && components[1] !== "detail") return;
            courseId = components[2];
        }
        if(!courseId) {
            return;
        }
        var baseUrl = "/fhws_project/api_v1/index.php/projects";
        this.$.requestProjectById.url = baseUrl + '/' + courseId;
        this.$.requestProjectById.generateRequest();
    },

    handleResponse: function(data) {
        this.project = data.detail.response;
        console.log(this.project);
    }
});