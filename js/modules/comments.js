const deleteForms = document.querySelectorAll(
    '.delete-comment-form'
);

deleteForms.forEach(form => {

    form.addEventListener('submit', async (e) => {

        e.preventDefault();

        if (!confirm('Удалить комментарий?')) {
            return;
        }

        const commentId = form.dataset.id;

        const formData = new FormData();

        formData.append('comment_id', commentId);

        try {

            const response = await fetch(
                '../ajax/comments/delete.php',
                {
                    method: 'POST',
                    body: formData
                }
            );

            const result = await response.json();

            if (result.status === 'success') {

                showMessage(result.message, 'success');

                form.closest('.box').remove();

            } else {

                showMessage(result.message, 'error');
            }

        } catch (error) {

            console.error(error);

            showMessage('Ошибка сервера', 'error');
        }
    });
});