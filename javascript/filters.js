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

        const url = '../api/api_ticket.php?' + encodeForAjax({after: after.value, before: before.value, status: status.value, priority: priority.value, department: department.value, agent: agent.value, tag: tag.value});

        const response = await fetch(url);
        const tickets = await response.json();

        const section = document.querySelector('#tickets');
        section.innerHTML = '';

        const h2 = document.createElement('h2')
        h2.textContent = 'Tickets'

        for (const ticket of tickets) {
            const article = document.createElement('article');
            article.classList.add('ticket');

            const a = document.createElement('a');
            a.href = '../pages/ticket.php?id=' + ticket.id;

            const header = document.createElement('header');
            header.classList.add('author');

            const img = document.createElement('img');
            img.src = '../profile_photos/' + ticket.author.photo;
            img.alt = 'Profile Photo';
            header.appendChild(img);

            const h3 = document.createElement('h3');
            h3.textContent = ticket.author.firstName + ' ' + ticket.author.lastName;
            header.appendChild(h3);

            a.appendChild(header);

            const h4 = document.createElement('h4');
            h4.textContent = ticket.title;
            a.appendChild(h4);

            if (ticket.status) {
                const pStatus = document.createElement('p');
                pStatus.classList.add('status', ticket.status.name.toLowerCase());
                pStatus.textContent = ticket.status.name;
                a.appendChild(pStatus);
            }

            const pDateOpened = document.createElement('p');
            pDateOpened.classList.add('date-opened');
            pDateOpened.textContent = ticket.dateOpened;
            a.appendChild(pDateOpened);

            const pPriority = document.createElement('p');
            if (ticket.priority) {
                pPriority.classList.add('priority', ticket.priority.name.toLowerCase());
                pPriority.textContent = ticket.priority.name;
            } else {
                pPriority.classList.add('priority');
                pPriority.textContent = 'None';
            }
            a.appendChild(pPriority);

            article.appendChild(a);

            section.appendChild(article);
        }
    })
}
