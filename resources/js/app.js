let showError = (text) => {
    let error_box = `
    <div class="message-box error-box" id="error-box">
        <p>{{ ${text} }}</p>
    </div>
    `

    document.querySelector('body').appendChild(error_box)

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