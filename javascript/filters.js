const filter = document.querySelector('#filter');

if (filter) {
    filter.addEventListener('click', async function (event) {
        event.preventDefault();
        const csrf = document.querySelector('#csrf');
        const after = document.querySelector('#after');
        const before = document.querySelector('#before');
        const status = document.querySelector('#status');
        const priority = document.querySelector('#priority');
        const department = document.querySelector('#department');
        const agent = document.querySelector('#agent');
        const tag = document.querySelector('#tag');
        const offset = document.querySelector('#offset');

        const response = await fetch('../api/api_ticket.php?id=1');
        const ticket = await response.json();
        console.log(ticket);

        const section = document.querySelector('#tickets');
        section.innerHTML = '';

        const article = document.createElement('article');
        article.classList.add('ticket');

        const a = document.createElement('a');
        a.href = '../pages/ticket.php?id=' + ticket.id;

        const header = document.createElement('header');
        header.classList.add('author');

        /* ... */

        article.appendChild(a);
        article.appendChild(header);
        section.appendChild(article);
    })
} else {
    console.log('far')
}