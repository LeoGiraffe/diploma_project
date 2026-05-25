function showMessage(message, type = 'success') {

    const div = document.createElement('div');
    div.className = `message ${type}`;

    div.innerHTML = `
        <span>${message}</span>
        <i class='bx bx-x'></i>
    `;

    document.body.appendChild(div);

    const remove = () => {
        div.style.opacity = '0';
        div.style.transform = 'translateY(-10px)';
        div.style.transition = '0.3s';

        setTimeout(() => div.remove(), 300);
    };

    div.querySelector('i').onclick = remove;

    setTimeout(remove, 4000);
}