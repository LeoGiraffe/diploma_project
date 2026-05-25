const form = document.querySelector('.contact-form');

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    console.log('FORM DATA:', [...formData]); // 🔥 проверка

    const res = await fetch('/Online_education/ajax/contact/send.php', {
        method: 'POST',
        body: formData
    });

    const result = await res.json();

    console.log(result);

    showMessage(result.message, result.status);
});