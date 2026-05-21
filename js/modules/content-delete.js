const deleteBtn = document.getElementById(
    'deleteContentBtn'
);

if (deleteBtn) {

    deleteBtn.addEventListener(
        'click',
        async () => {

            if (!confirm('Удалить материал?')) {
                return;
            }

            const videoId =
                document.querySelector(
                    '[name="video_id"]'
                ).value;

            const formData = new FormData();

            formData.append(
                'video_id',
                videoId
            );

            try {

                const response =
                    await fetch(
                        '../ajax/content/delete.php',
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
                            'content.php';

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