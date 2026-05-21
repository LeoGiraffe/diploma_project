const updateForm = document.getElementById(
    'updatePlaylistForm'
);

if (updateForm) {

    updateForm.addEventListener(
        'submit',
        async (e) => {

            e.preventDefault();

            const formData =
                new FormData(updateForm);

            try {

                const response =
                    await fetch(
                        '../ajax/playlist/update.php',
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