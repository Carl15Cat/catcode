let variable_types = null;
fetch('/getVariableTypes').then((response) => response.json()).then((data) => {variable_types = data});

const variables_list = document.getElementById('variables_list');
let variables_count = variables_list.children.length;

document.getElementById('addVariableButton').addEventListener('click', () => {
    const variable_id = variables_count++;

    let var_types_html;

    variable_types.forEach(element => {
        var_types_html += `<option>${element.name}</option>`
    });

    let html = `                    
    <div class="variable" id="variable_${variable_id}">
        <label>
            <p>Тип</p>
            <select name="variable_type[${variable_id}]">
                ${var_types_html}
            </select>
        </label>
        <label>
            <p>Название</p>
            <input type="text" name="variable_name[${variable_id}]">
        </label>
        <button type="button" class="danger small" onclick="delete_variable(${variable_id})">Удалить</button>
    </div>`

    let div = document.createElement('div');
    div.innerHTML = html.trim();
    variables_list.appendChild(div);
});

let delete_variable = (variable_id) => {
    document.getElementById(`variable_${variable_id}`).remove();
}
