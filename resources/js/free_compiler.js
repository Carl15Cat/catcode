const execute_button = document.getElementById('executeButton')
const output_field = document.getElementById('output_field')
const input_field = document.getElementById('input')
let programming_languages;

language_select.addEventListener('change', () => change_language(language_select, code_textarea, highlighting_content));

fetch(window.location.origin + "/api/languages/").then((response) => response.json())
.then((data) => {
    programming_languages = data
    setFields(programming_languages)
})

execute_button.addEventListener('click', () => {
    let code = code_textarea.value;
    let language_id = language_select.value;
    let stdin = input_field.value;

    let data = {
        source_code: code,
        language_id: language_id,
        stdin: stdin,
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
        showError("Ошибка компилятора")
        execute_button.innerText = "Запустить"
        return true;
    }

    return false;
}

// Вывод результата
let output = (data) => {
    if(data.status.id == 3) {
        output_field.classList.remove('compile-error')
        output_field.innerText = data.stdout;
    } else {
        output_field.classList.add('compile-error')
        output_field.innerText = data.stderr == null ? data.compile_output : data.stderr;
    }
}

let setFields = (programming_languages) => {
    selected_language = localStorage.getItem('free-compiler-language');
    programming_languages.forEach((language) => {
        language_select.innerHTML += `<option value="${language.id}" ${selected_language == language.id ? 'selected' : ''}>${language.name}</option>`
    })

    language_select.addEventListener('change', () => {localStorage.setItem('free-compiler-language', language_select.value)});
    code_textarea.addEventListener('input', () => {
        let language = programming_languages.find(obj => { return obj.id == language_select.value }) // Находит объект языка
        localStorage.setItem(`free-compiler-${language.name}`, code_textarea.value)
    });

    input_field.value = localStorage.getItem('input_value');
    input_field.addEventListener('input', () => localStorage.setItem('input_value', input_field.value)) 

    change_language(language_select, code_textarea, highlighting_content);
    sync_scroll(code_textarea, highlighting_element);
}

// Смена языка
let change_language = (language_select, code_textarea, highlighting_content) => {
    let language = programming_languages.find(obj => { return obj.id == language_select.value }) // Находит объект языка

    for(let i = 0; i < highlighting_content.classList.length; i++) {
        let toremove = highlighting_content.classList[i];
        highlighting_content.classList.remove(toremove)
    }
    highlighting_content.classList.add('language-' + language.highlight_name);

    code = localStorage.getItem(`free-compiler-${language.name}`);

    if(!code) {
        code = language.default_code
    }

    code_textarea.value = code;
    update_highlighting(code_textarea, highlighting_content);
}