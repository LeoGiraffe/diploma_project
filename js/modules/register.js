const registerForm = document.getElementById(
    'registerForm'
);

if (registerForm) {

    registerForm.addEventListener(
        'submit',
        async (e) => {

            e.preventDefault();

            const formData =
                new FormData(registerForm);

            try {

                const response = await fetch(
                    '../ajax/auth/register.php',
                    {
                        method: 'POST',
                        body: formData
                    }
                );

                const result =
                    await response.json();

                if (result.status === 'success') {

                    showMessage(
                        result.message,
                        'success'
                    );

                    setTimeout(() => {

                        window.location.href =
                            result.redirect;

                    }, 1500);

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
        }
    );
}