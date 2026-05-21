const deleteBtn = document.getElementById(
    'deletePlaylistBtn'
);

if (deleteBtn) {

    deleteBtn.addEventListener(
        'click',
        async () => {

            if (!confirm('Удалить плейлист?')) {
                return;
            }

            const playlistId =
                document.querySelector(
                    '[name="playlist_id"]'
                ).value;

            const formData = new FormData();

            formData.append(
                'playlist_id',
                playlistId
            );

            try {

                const response =
                    await fetch(
                        '../ajax/playlist/delete.php',
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

                if (
                    result.status === 'success'
                ) {

                    setTimeout(() => {

                        window.location.href =
                            'playlist.php';

                    }, 1000);
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