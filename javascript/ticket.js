const apply = document.querySelector('#apply');

if (apply) {
    apply.addEventListener('click', async function (event) {
        event.preventDefault();
        const id = document.querySelector('#id');
        const csrf = document.querySelector('#csrf');
        const status = document.querySelector('#status');
        const priority = document.querySelector('#priority');
        const department = document.querySelector('#department');
        const agent = document.querySelector('#agent');
        // TAGS
        const url = '../api/api_ticket.php/';
        const data = {id: id.value, status: status.value, priority: priority.value, department: department.value, agent: agent.value};
        const response = await fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: encodeForAjax(data),
        })
        const success = await response.json();

        let messages = document.querySelector('#messages');
        if (!messages) {
            messages = document.createElement('section');
            messages.id = 'messages';
        }
        const message = document.createElement('article');
        if (success) {
            message.classList.add('success');
            message.textContent = 'Ticket properties successfully edited';
            // CHANGES !!!!
        }
        else {
            message.classList.add('error');
            message.textContent = 'Ticket properties could not be edited';
        }
        messages.appendChild(message);

        const body = document.querySelector('body');
        const main = document.querySelector('#ticket-page');
        body.insertBefore(messages, main);
    })
}

const send = document.querySelector('#send');
if (send) {
    send.addEventListener('click', async function (event) {
        event.preventDefault();
        const id = document.querySelector('#id');
        const newMessage = document.querySelector('#new-message');

        const url = '../api/api_message.php/';
        const data = {id: id.value, content: newMessage.value};
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: encodeForAjax(data),
        })
        const success = await response.json();

        if (success) {
            const allMessages = document.querySelector('#all-messages');

            const article = document.createElement('article');
            article.classList.add('agent');

            const header = document.createElement('header');

            const id = document.querySelector('#message-author');
            const url = '../api/api_user.php?' + encodeForAjax({id: id.value});
            const response = await fetch(url)
            const user = await response.json();

            const img = document.createElement('img');
            img.classList.add('message-photo');
            img.src = '../profile_photos/' + user.photo;
            img.alt = 'Profile Photo';
            header.appendChild(img);

            const p = document.createElement('p');
            p.textContent = user.firstName + ' ' + user.lastName;
            header.appendChild(p);

            const date = document.createElement('p');
            date.classList.add('message-date');
            date.textContent = new Date().toJSON().slice(0, 10);
            header.appendChild(date);

            const content = document.createElement('p');
            content.classList.add('message-content');
            content.textContent = newMessage.value;

            article.appendChild(header);
            article.appendChild(content);

            const form = document.querySelector('.messageBoard-form')
            allMessages.insertBefore(article, form);
        } else {
            /* ... */
        }
    })
}
