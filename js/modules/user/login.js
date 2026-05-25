const loginForm = document.querySelector('.login');

if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(loginForm);

        try {
            const response = await fetch('ajax/user/login.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            showMessage(result.message, result.status);

            if (result.status === 'success') {
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 1000);
            }

        } catch (error) {
            console.error(error);
            showMessage('Ошибка сервера', 'error');
        }
    });
}