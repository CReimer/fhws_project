/**
 * Created by christopher on 08.02.17.
 */
var jwt_token;

function loginSubmit(user, password) {
    // console.log("Echo " + user + ":" + password);
    var loginRequest = new XMLHttpRequest();

    loginRequest.onreadystatechange = function () {
        if (loginRequest.readyState == XMLHttpRequest.DONE) {
            // console.log(loginRequest.response)
        }
        if (loginRequest.readyState == XMLHttpRequest.HEADERS_RECEIVED) {
            // console.log(loginRequest.getResponseHeader("x-fhws-jwt-token"));
            jwt_token = loginRequest.getResponseHeader("x-fhws-jwt-token");
        }
    };
    loginRequest.open("GET", "../api_v1/index.php/login");
    loginRequest.setRequestHeader("Authorization", "Basic " + btoa(user + ':' + password));
    loginRequest.send();
}