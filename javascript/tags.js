const input = document.querySelector('#tags');
if (input) {
    input.addEventListener('keydown', function (event) {
        console.log('keydown');
        if (event.key === 'Enter' || event.key === 'Tab') {
            console.log('event');
            event.preventDefault();
            const tag = input.value;

            /* PEDIDO A API */

            const button = document.createElement('button');
            button.formAction = '../actions/action_delete_ticket_tag.php';
            button.formMethod = 'post';
            button.classList.add('all-tags');
            button.name = 'name';
            button.textContent = tag;

            const section = document.querySelector('#property-tag');
            section.insertBefore(button, input);

            input.value = "";
        }
    })
}
