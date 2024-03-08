const groupTable = document.getElementById('group_tbody');
const taskTypeSelect = document.getElementById('task_type_select');

// Переключение видимости заданий между "Все", "Открытые" и "Закрытые"
taskTypeSelect.addEventListener('change', () => {
    [...groupTable.children].forEach(element => {
        if(element.classList.contains(taskTypeSelect.value) || taskTypeSelect.value == 'all') {
            element.style.display = 'table-row';
        } else {
            element.style.display = 'none';
        }
    });
});