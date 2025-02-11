function increaseCounter() {
    let counter = document.getElementById("counter-value");
    counter.innerText = parseInt(counter.innerText) + 1;
}

function decreaseCounter() {
    let counter = document.getElementById("counter-value");
    let currentValue = parseInt(counter.innerText);
    if (currentValue > 0) {
        counter.innerText = currentValue - 1;
    }
}

