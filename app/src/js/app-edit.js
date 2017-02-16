/**
 * Created by christopher on 09.02.17.
 */

Polymer({
    is: 'app-edit',
    properties: {
        project: {
            type: Object
        }
    },
    ready: function () {
        if (this.route.path.split("/")[2]) {
            this.$.requestProjectById.url = this.$.requestProjectById.url + '/' + this.route.path.split("/")[2];
            this.$.requestProjectById.generateRequest();
        }
        else {
            this.project = [
                {
                    name: "",
                    desc: "",
                }
            ]
        }
    },
    handleResponse: function (data) {
        console.log(data.detail.response);
        this.project = data.detail.response;
    },
    handleTap: function() {
        newEntrySubmit(this.$.projectForm);
    }

});


function newEntrySubmit(data) {
    var xhr = new XMLHttpRequest();

    var formData = new FormData();
    var name = data.getElementsByClassName('title')[0].value;
    var desc = data.getElementsByClassName('description')[0].value;
    if (!name || !desc) {
        return
    }

    formData.append('name', name);
    formData.append('desc', desc);

    console.log(formData);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            console.log(xhr.response)
        }
    };
    console.log(data.getElementsByClassName('title')[0].value);
    if (window.location.pathname.split('/')[2]) {
        xhr.open("POST", "../api_v1/index.php/projects/" + window.location.pathname.split('/')[2]);
    }
    else {
        xhr.open("POST", "../api_v1/index.php/projects");
    }

    // xhr.setRequestHeader("Authorization", "Bearer " + jwt_token);
    xhr.send(formData);
}

