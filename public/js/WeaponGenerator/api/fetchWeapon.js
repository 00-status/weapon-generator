
// Reaches out to our webserver and grabs a random name.
const fetchWeapon = (callback) => {
    var xhttp = new XMLHttpRequest();
    // Callback for when the request completes.
    xhttp.onreadystatechange = () => {
        if (xhttp.readyState == XMLHttpRequest.DONE && xhttp.status == 200) {
            return callback(xhttp.responseText);
        }
    };
    // Create the request
    xhttp.open('GET', 'http://localhost:8080/api/generate_weapon', true);
    xhttp.send();
};

export default fetchWeapon;
