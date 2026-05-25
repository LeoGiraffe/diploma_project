document.addEventListener('click', async (e) => {

    if (!e.target.classList.contains('delete-comment-btn')) return;

    const id = e.target.dataset.id;

    const formData = new FormData();
    formData.append('comment_id', id);

    const res = await fetch('../ajax/comments/delete.php', {
        method: 'POST',
        body: formData
    });

    const result = await res.json();

    showMessage(result.message, result.status);

    if (result.status === 'success') {
        e.target.closest('.box')?.remove();
    }
});