const list_container = document.getElementById('list_container');

let handleListChange = (src) => {
    for(let item of list_container.children) {
        item.classList.add('no-display');
    }

    document.getElementById('list_' + src.value).classList.remove('no-display');
}