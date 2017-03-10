var jwt_token;

function loginSubmit(user, password) {
    // console.log("Echo " + user + ":" + password);
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            // console.log(loginRequest.response)
        }
        if (xhr.readyState == XMLHttpRequest.HEADERS_RECEIVED) {
            // console.log(loginRequest.getResponseHeader("x-fhws-jwt-token"));
            jwt_token = xhr.getResponseHeader("x-fhws-jwt-token");
        }
    };
    xhr.open("GET", "../api_v1/index.php/login");
    xhr.setRequestHeader("Authorization", "Basic " + btoa(user + ':' + password));
    xhr.send();
}