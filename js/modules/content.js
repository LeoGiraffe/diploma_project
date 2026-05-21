const contentForm = document.getElementById('contentForm');

if (contentForm) {

    contentForm.addEventListener('submit', async (e) => {

        e.preventDefault();

        const formData = new FormData(contentForm);

        try {

            const response = await fetch(
                '../ajax/content/create.php',
                {
                    method: 'POST',
                    body: formData
                }
            );

            const result = await response.json();

            if (result.status === 'success') {

                showMessage(result.message, 'success');

                contentForm.reset();

            } else {

                showMessage(result.message, 'error');
            }

        } catch (error) {

            console.error(error);

            showMessage('Ошибка сервера', 'error');
        }
    });
}