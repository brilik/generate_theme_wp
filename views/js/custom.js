// variables
let pathToRequest = 'controllers/ajax/request.php';
let divSuccess = document.getElementById('success');
let form = document.getElementsByClassName('form-generate')[0].querySelector('form');

// functions
function serialize(form) {
    if (!form || form.nodeName !== "FORM") {
        return;
    }
    let i, j, q = [];
    for (i = form.elements.length - 1; i >= 0; i = i - 1) {
        if (form.elements[i].name === "") {
            continue;
        }
        switch (form.elements[i].nodeName) {
            case 'INPUT':
                switch (form.elements[i].type) {
                    case 'text':
                    case 'tel':
                    case 'email':
                    case 'hidden':
                    case 'password':
                    case 'button':
                    case 'reset':
                    case 'submit':
                        q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
                        break;
                    case 'checkbox':
                    case 'radio':
                        if (form.elements[i].checked) {
                            q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
                        }
                        break;
                }
                break;
            case 'file':
                break;
            case 'TEXTAREA':
                q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
                break;
            case 'SELECT':
                switch (form.elements[i].type) {
                    case 'select-one':
                        q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
                        break;
                    case 'select-multiple':
                        for (j = form.elements[i].options.length - 1; j >= 0; j = j - 1) {
                            if (form.elements[i].options[j].selected) {
                                q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].options[j].value));
                            }
                        }
                        break;
                }
                break;
            case 'BUTTON':
                switch (form.elements[i].type) {
                    case 'reset':
                    case 'submit':
                    case 'button':
                        q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
                        break;
                }
                break;
        }
    }
    return q.join("&");
}
function download(request,pathname){
    var link = document.createElement('a');
    document.body.appendChild(link);
    link.href = window.URL.createObjectURL(request.response);
    link.download = pathname;
    link.click()
}
// actions
form.onsubmit = function (e) {
    // Stop default send
    e.preventDefault();
    // Create instance object
    let xhr = new XMLHttpRequest();
    // Open connection
    xhr.open('post', pathToRequest);
    // Install format POST-request content header
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    // Send POST-request
    xhr.send(serialize(form));
    // Install function-handler for changing property readyState
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) { // check answer from server and ready for processing
            if (xhr.status === 200) { // check success answer
                // Object
                let result = JSON.parse(xhr.responseText);
                // Show validation errors
                if(result.errors ) {
                    divSuccess.innerHTML = result.errors.join('<br>');
                    return false;
                }
                // Show success generate theme
                if( result.themeName ){
                    divSuccess.innerHTML = result.themeName;
                }
                // Download archive theme
                if( result.getArchive ){
                    // window.location.href = result.getArchive;
                    console.log(result.getArchive);
                    // download(xhr, result.getArchive);
                    window.location = result.getArchive;
                }
            }
        }
    };
};