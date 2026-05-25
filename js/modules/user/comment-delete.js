document.addEventListener('click', async (e) => {

    const btn = e.target.closest('.delete-comment-btn');
    if (!btn) return;

    e.preventDefault();

    if (!confirm('Удалить комментарий?')) return;

    const id = btn.dataset.id;

    const formData = new FormData();
    formData.append('comment_id', id);

    const res = await fetch('ajax/comments/delete.php', {
        method: 'POST',
        body: formData
    });

    const result = await res.json();

    showMessage(result.message, result.status);

    if (result.status === 'success') {

        const box = btn.closest('.comment-box') || btn.closest('.box');

        if (box) box.remove();
    }
});