document.querySelector('.add-comment')?.addEventListener('submit', async (e) => {

    e.preventDefault();

    const formData = new FormData(e.target);

    console.log([...formData.entries()]);

    const res = await fetch('ajax/user_comments/add.php', {
        method: 'POST',
        body: formData
    });

    const data = await res.json();

    console.log(data);

    showMessage(data.message, data.status);

    if (data.status === 'success') {

        e.target.reset();

        location.reload();
    }

});