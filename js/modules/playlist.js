const playlistForm = document.getElementById('playlistForm');

if (playlistForm) {

    playlistForm.addEventListener('submit', async (e) => {

        e.preventDefault();

        const formData = new FormData(playlistForm);

        try {

            const response = await fetch(
                '../ajax/playlist/create.php',
                {
                    method: 'POST',
                    body: formData
                }
            );

            const result = await response.json();

            if (result.status === 'success') {

                showMessage(result.message, 'success');

                playlistForm.reset();

            } else {

                showMessage(result.message, 'error');
            }

        } catch (error) {

            showMessage('Ошибка сервера', 'error');

            console.error(error);
        }
    });
}