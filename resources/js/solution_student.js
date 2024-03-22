update_highlighting(code_textarea, highlighting_content)
const execute_button = document.getElementById('executeButton');
const solution_id = execute_button.dataset.solutionId;

execute_button.addEventListener('click', () => {
    let data = {
        source_code: code_textarea.value,
    }

    execute_button.innerText = "Выполняется..."

    fetch(window.location.origin + "/api/solution/" + solution_id, {
        method: 'POST',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded;',
            'X-CSRF-Token': document.querySelector('meta[name="_token"]').content,
        },
        body: new URLSearchParams(data),
        credentials: "include",
    }).then((response) => {
        if(response.status != 200) {
            showError("Ошибка выполнения кода")
        }

        return response.json()
    }).then((data) => {
        console.log(data);
        clearPreviousResults();
        getResults();
    })
});

let getResults = async () => {
    getResultsRequest().then((data) => {
        const autotests = data.results;
        let isWaiting = false;

        Object.keys(autotests).forEach((key) => {
            const autotest = document.getElementById("autotest-" + key);

            if(autotests[key].status.id < 3) {
                autotest.classList.add('waiting');
                isWaiting = true;
            } else {
                if (autotests[key].status.id > 3) {
                    autotest.classList.remove('waiting');
                    autotest.classList.add('error');
                } else {
                    autotest.classList.remove('waiting');
                    autotest.classList.add('success');
                }

                autotest.querySelector('.output').innerText = autotests[key].stdout;
            } 
        });

        if(isWaiting) { 
            setTimeout(getResults, 1000) 
        } else {
            execute_button.innerText = "Выполнить"
        }
    })
}

let getResultsRequest = async () => {
    return await fetch(window.location.origin + "/api/solution/" + solution_id, {
        method: "GET",
        credentials: "include",
    }).then((response) => {
        if(response.status != 200) {
            showError("Ошибка выполнения кода")
        }

        return response.json()
    }).then((data) => data)
}

let clearPreviousResults = () => {
    document.querySelectorAll('.autotest').forEach((test) => {
        test.classList.remove('waiting');
        test.classList.remove('error');
        test.classList.remove('success');

        test.querySelector('.output').innerText = "*";
    })

}

getResults();