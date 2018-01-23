const deleteButtons = document.querySelectorAll('a.delete');

deleteButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        let form = document.getElementById('list');

        if (confirm(`Sure you want to delete "${this.title}"?`)) {
            form.action = this.href;
            form.submit();
        }
    });
});