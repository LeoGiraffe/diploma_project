function showMessage(message, type = 'success') {

    const div = document.createElement('div');

    div.className = `message ${type}`;

    div.innerHTML = `
        <span>${message}</span>
        <i class='bx bx-x'></i>
    `;

    document.body.appendChild(div);

    div.querySelector('i').onclick = () => {
        div.remove();
    };

    setTimeout(() => {
        div.remove();
    }, 4000);
}   