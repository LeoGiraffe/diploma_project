document.querySelectorAll('.deleteContentBtn').forEach(btn => {
    btn.addEventListener('click', async function () {

        if (!confirm('Удалить материал?')) return;

        const videoId = this.dataset.id;

        const formData = new FormData();
        formData.append('video_id', videoId);

        const response = await fetch('../ajax/content/delete.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        showMessage(result.message, result.status);

        if (result.status === 'success') {
            this.closest('.box').remove();
            if (window.location.pathname.includes('view_content.php')) {
                setTimeout(() => {
                    window.history.back();
                }, 800);
            }
        }
    });
});