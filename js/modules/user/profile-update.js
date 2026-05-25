const form = document.getElementById('profileForm');

if (form) {

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        try {

            const res = await fetch('ajax/user/update.php', {
                method: 'POST',
                body: formData
            });

            const data = await res.json();

            showMessage(data.message, data.status);

            if (data.status === 'success') {
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }

        } catch (err) {
            console.error(err);
            showMessage('Ошибка сервера', 'error');
        }
    });

}