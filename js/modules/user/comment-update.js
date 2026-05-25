document.addEventListener('click', async (e) => {

    const editBtn = e.target.closest('.edit-comment-btn');
    if (editBtn) {

        const box = editBtn.closest('.comment-box');

        const text = box.querySelector('.comment-text');
        const textarea = box.querySelector('.edit-area');

        textarea.value = text.textContent.trim();

        text.style.display = 'none';
        textarea.style.display = 'block';

        box.querySelector('.edit-comment-btn').style.display = 'none';
        box.querySelector('.save-comment-btn').style.display = 'inline-block';
        box.querySelector('.cancel-comment-btn').style.display = 'inline-block';
    }

    const saveBtn = e.target.closest('.save-comment-btn');
    if (saveBtn) {

        console.log('SAVE CLICK WORKS');

        const box = saveBtn.closest('.comment-box');
        const id = box.dataset.id;
        const textarea = box.querySelector('.edit-area');

        const formData = new FormData();
        formData.append('comment_id', id);
        formData.append('text', textarea.value);

        const res = await fetch('ajax/user_comments/update.php', {
            method: 'POST',
            body: formData
        });

        const result = await res.json();
        showMessage(result.message, result.status);

        if (result.status === 'success') {
            box.querySelector('.comment-text').innerHTML =
                textarea.value.replace(/\n/g, '<br>');

            exitEdit(box);
        }
    }

    const cancelBtn = e.target.closest('.cancel-comment-btn');
    if (cancelBtn) {
        const box = cancelBtn.closest('.comment-box');
        exitEdit(box);
    }

});

function exitEdit(box) {

    box.querySelector('.comment-text').style.display = 'block';
    box.querySelector('.edit-area').style.display = 'none';

    box.querySelector('.edit-comment-btn').style.display = 'inline-block';
    box.querySelector('.save-comment-btn').style.display = 'none';
    box.querySelector('.cancel-comment-btn').style.display = 'none';
}