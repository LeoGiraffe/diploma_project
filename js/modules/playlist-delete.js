document.querySelectorAll('.deletePlaylistBtn').forEach(btn => {

    btn.addEventListener('click', async function (e) {

        e.preventDefault();

        if (!confirm('Удалить плейлист?')) return;

        const playlistId = this.dataset.id;

        const formData = new FormData();
        formData.append('playlist_id', playlistId);

        try {

            const response = await fetch(
                '../ajax/playlist/delete.php',
                {
                    method: 'POST',
                    body: formData
                }
            );

            const result = await response.json();

            showMessage(
                result.message,
                result.status
            );

            if (result.status === 'success') {

                if (
                    window.location.pathname.includes('view_playlist.php') ||
                    window.location.pathname.includes('update_playlist.php')
                ) {

                    setTimeout(() => {
                        window.location.href = 'playlist.php';
                    }, 1000);

                    return;
                }
                const box = this.closest('.box');

                if (box) {
                    box.remove();
                }

            }

        } catch (error) {

            console.error(error);

            showMessage(
                'Ошибка сервера',
                'error'
            );
        }

    });

});