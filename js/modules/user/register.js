const form = document.querySelector('.register-form');

if (form) {
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        try {
            const response = await fetch('ajax/user/register.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            alert(result.message);

            if (result.status === 'success') {
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 1000);
            }

        } catch (error) {
            console.error(error);
            alert('Ошибка сервера');
        }
    });
}