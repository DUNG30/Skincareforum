const csrf = document.querySelector('meta[name="csrf-token"]').content;

document.querySelectorAll('.react-option').forEach(btn => {
    btn.addEventListener('click', () => {
        const type = btn.dataset.type;
        const postId = btn.dataset.postId;

        fetch(`/post/${postId}/react`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ type })
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            // update UI nếu muốn
        });
    });
});
