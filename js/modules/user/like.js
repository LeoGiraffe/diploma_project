document.querySelectorAll('.like-btn').forEach(btn => {
    btn.addEventListener('click', async () => {

        const contentId = btn.dataset.contentId;

        const formData = new FormData();
        formData.append('content_id', contentId);

        const res = await fetch('ajax/content/like.php', {
            method: 'POST',
            body: formData
        });

        const data = await res.json();

        showMessage(data.message, data.status === 'added' ? 'success' : 'info');

        const icon = btn.querySelector('i');

        if (data.status === 'added') {
            icon.className = 'bx bxs-heart';
        } else {
            icon.className = 'bx bx-heart';
        }
    });
});