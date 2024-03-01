const highlighting_content = document.getElementById('highlighting-content');
const highlighting_element = document.getElementById('highlighting');
const code_textarea = document.getElementById('code');
const language_select = document.getElementById('language_select');

code_textarea.addEventListener('input', () => update_highlighting(code_textarea, highlighting_content));
code_textarea.addEventListener('input', () => sync_scroll(code_textarea, highlighting_content));
code_textarea.addEventListener('scroll', () => sync_scroll(code_textarea, highlighting_element));
code_textarea.addEventListener('keydown', (event) => add_tab(event, code_textarea, highlighting_content));
language_select.addEventListener('change', () => change_language(language_select, code_textarea, highlighting_content));

// Обновить подсветку синтаксиса
let update_highlighting = (source_element, highlighting_content) => {
    let code = source_element.value;
    highlighting_content.innerHTML = encrypt_string(code);

    Prism.highlightElement(highlighting_content)
}

// Зашифровывает строку, чтобы & и < отображались при вставке в innerHTML
let encrypt_string = (value) => {
    // & должен быть первым
    return value.replace(new RegExp("&", "g"), "&amp;").replace(new RegExp("<", "g"), "&lt;");
}

// Возможность скроллить
let sync_scroll = (source_element, highlighting_element) => {
    highlighting_element.scrollTop = source_element.scrollTop;
    highlighting_element.scrollLeft = source_element.scrollLeft;
}

// Возможность ставить символ табуляции в коде
let add_tab = (event, code_textarea, highlighting_content) => {
    if(event.key == 'Tab'){
        event.preventDefault();
        let start = code_textarea.selectionStart;
        let end = code_textarea.selectionEnd;
    
        code_textarea.value = code_textarea.value.substring(0, start) + "\t" + code_textarea.value.substring(end);

        update_highlighting(code_textarea, highlighting_content);
        sync_scroll(code_textarea, highlighting_content);

        code_textarea.selectionStart = code_textarea.selectionEnd = start + 1;
    }
}

// Смена языка
let change_language = (language_select, code_textarea, highlighting_content) => {
    let new_language = language_select.options[language_select.selectedIndex].text; // Получает название текстом

    // Исправление подсветки с-подобных языков
    if(new_language == "C++") {
        new_language = "cpp";
    } else if (new_language == "C#") {
        new_language = "cs";
    }

    for(let i = 0; i < highlighting_content.classList.length; i++) {
        let toremove = highlighting_content.classList[i];
        highlighting_content.classList.remove(toremove)
    }

    highlighting_content.classList.add('language-' + new_language.toLowerCase());

    update_highlighting(code_textarea, highlighting_content);
}

change_language(language_select, code_textarea, highlighting_content);
sync_scroll(code_textarea, highlighting_element);