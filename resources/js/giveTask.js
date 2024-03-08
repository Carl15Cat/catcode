const language_checkboxes = document.querySelectorAll('.language-checkbox');
const select_all_checkbox = document.getElementById('select-all-checkbox');

select_all_checkbox.addEventListener('change', () => {
    language_checkboxes.forEach((language_checkbox) => {
        language_checkbox.checked = select_all_checkbox.checked;
    })
});

language_checkboxes.forEach((language_checkbox) => {
    language_checkbox.addEventListener('change', (event) => {
        let value = event.target.checked;
        let same = true;

        language_checkboxes.forEach((elem) => {
            if(elem.checked != value) {
                same = false;
            }
        });

        if(same) {
            select_all_checkbox.checked = value;
        } else {
            select_all_checkbox.checked = false;
        }
    });
});