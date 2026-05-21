const form = document.getElementById(
    'updateContentForm'
);

if (form) {

    form.addEventListener(
        'submit',
        async (e) => {

            e.preventDefault();

            const formData =
                new FormData(form);

            try {

                const response =
                    await fetch(
                        '../ajax/content/update.php',
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