document.getElementById('executeButton').addEventListener('click', () => {
    let code = code_textarea.value;
    let language_id = language_select.value;

    let data = {
        source_code: code,
        language_id: language_id,
    }

    console.log(data)

    fetch(window.location.origin + "/api/compiler", {
        method: 'POST',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded;'
        },
        body: new URLSearchParams(data),
        credentials: "include",
    }).then((response) => response.json())
    .then((data) => console.log(data));
});