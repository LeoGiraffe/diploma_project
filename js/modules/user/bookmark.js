document.addEventListener('click', async (e) => {
console.log('bookmark js loaded');
    if (e.target.closest('.bookmark-btn')) {

        const btn = e.target.closest('.bookmark-btn');
        const id = btn.dataset.id;

        const formData = new FormData();
        formData.append('list_id', id);

        try {
            const res = await fetch('/Online_education/ajax/bookmark/toggle.php', {
                method: 'POST',
                body: formData
            });

            const result = await res.json();

            showMessage(result.message, result.status);

            if (result.status === 'success') {

                if (result.action === 'added') {
                    btn.innerHTML = `<i class="bx bx-bookmark"></i><span>Сохранено</span>`;
                } else {
                    btn.innerHTML = `<i class="bx bx-bookmark"></i><span>Сохранить</span>`;
                }
            }

        } catch (err) {
            console.error(err);
            showMessage('Ошибка сервера', 'error');
        }
    }
});