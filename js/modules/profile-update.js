const profileForm = document.getElementById(
    'profileUpdateForm'
);

if (profileForm) {

    profileForm.addEventListener(
        'submit',
        async (e) => {

            e.preventDefault();

            const formData =
                new FormData(profileForm);

            try {

                const response =
                    await fetch(
                        '../ajax/profile/update.php',
                        {
                            method: 'POST',
                            body: formData
                        }
                    );

                const result =
                    await response.json();

                showMessage(
                    result.message,
                    result.status
                );

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