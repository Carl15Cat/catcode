let showError = (text) => {
    let htmlString = `
    <div class="message-box error-box" id="error-box">
        <p>${text}</p>
    </div>
    `

    let div = document.createElement('div')
    div.innerHTML = htmlString.trim()

    document.querySelector('body').appendChild(div.firstChild)

    addQS();
}

let addQS = () => {
    document.querySelectorAll('.message-box').forEach(box => {
        document.addEventListener("click", function(event) {
            box.style.opacity = 0;
        }, {once: true});
    });
}

addQS();