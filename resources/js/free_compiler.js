const execute_button = document.getElementById('executeButton')
const output_field = document.getElementById('output_field')

execute_button.addEventListener('click', () => {
    let code = code_textarea.value;
    let language_id = language_select.value;

    let data = {
        source_code: code,
        language_id: language_id,
    }

    execute_button.innerText = "Выполняется..."

    fetch(window.location.origin + "/api/submissions", {
        method: 'POST',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded;'
        },
        body: new URLSearchParams(data),
        credentials: "include",
    }).then((response) => {
        if(hanleError(response.status)){ return }

        response.json().then((data) => submissionFetch(data['token']));
    })

});

// Отправить запрос для проверки состояния submission
let submissionFetch = (token) => {
    fetch(window.location.origin + "/api/submissions/" + token, {
        method: 'GET',
    }).then((response) => {
        if(hanleError(response.status)){ return }

        response.json().then((data) => {
            if(data.status.id >= 3) {
                execute_button.innerText = "Запустить"
                output(data)
            } else {
                setTimeout(submissionFetch, 1100, token) // Не ставить задежку меньше 1 секунды, чтобы не получить ответ 429 Too Many Requests
            }
        })
    })

}

// Возвращает true при коде ошибки >=300
let hanleError = (status) => {
    if(status >= 300) {
        console.log("Error"); // Обработать позже
        execute_button.innerText = "Запустить"
        return true;
    }

    return false;
}

// Вывод результата
let output = (data) => {
    console.log(data)
    if(data.status.id == 3) {
        output_field.classList.remove('compile-error')
        output_field.innerText = data.stdout;
    } else {
        output_field.classList.add('compile-error')
        output_field.innerText = data.stderr == null ? data.compile_output : data.stderr;
    }
}

code_textarea.addEventListener('input', () => {localStorage.setItem('free-compiler-code', code_textarea.value)});
language_select.addEventListener('change', () => {localStorage.setItem('free-compiler-language', language_select.value)});

code_textarea.value = localStorage.getItem('free-compiler-code');

if (localStorage.getItem('free-compiler-language')) {
    language_select.value = localStorage.getItem('free-compiler-language');
}

change_language(language_select, code_textarea, highlighting_content);
sync_scroll(code_textarea, highlighting_element);