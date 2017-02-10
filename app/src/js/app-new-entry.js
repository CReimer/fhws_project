/**
 * Created by christopher on 09.02.17.
 */

function newEntrySubmit(data) {
    var xhr = new XMLHttpRequest();

    var formData = new FormData();
    formData.append('name', data.getElementsByClassName('title')[0].value);
    formData.append('desc', data.getElementsByClassName('description')[0].value);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            console.log(xhr.response)
        }
    };
    xhr.open("POST", "../api_v1/index.php/projects");
    xhr.setRequestHeader("Authorization", "Bearer " + jwt_token);
    xhr.send(formData);
}