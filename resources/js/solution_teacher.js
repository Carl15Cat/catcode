update_highlighting(code_textarea, highlighting_content)
const execute_button = document.getElementById('executeButton');
const solution_id = execute_button.dataset.solutionId;

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
            // setTimeout(getResults, 1000) 
        }
    })
}

let getResultsRequest = async () => {
    return await fetch(window.location.origin + "/api/solution/" + solution_id, {
        method: "GET",
        credentials: "include",
    }).then((response) => {
        if(response.status != 200) {
            showError("Ошибка получения результатов")
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