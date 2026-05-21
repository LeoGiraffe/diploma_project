const loginForm = document.getElementById(
    'loginForm'
);

if (loginForm) {

    loginForm.addEventListener('submit', async (e) => {

        e.preventDefault();

        const formData = new FormData(loginForm);

        try {

            const response = await fetch(
                '../ajax/auth/login.php',
                {
                    method: 'POST',
                    body: formData
                }
            );

            const result = await response.json();

            if (result.status === 'success') {

                showMessage(
                    result.message,
                    'success'
                );

                setTimeout(() => {

                    window.location.href =
                        result.redirect;

                }, 1000);

            } else {

                showMessage(
                    result.message,
                    'error'
                );
            }

        } catch (error) {

            console.error(error);

            showMessage(
                'Ошибка сервера',
                'error'
            );
        }
    });
}