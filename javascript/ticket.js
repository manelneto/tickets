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

        const url = '../api/api_message.php';
        const data = {id: id.value, content: newMessage.value};
        const response = await fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: encodeForAjax(data),
        })
        const success = await response.json();

        if (success) {
            const allMessages = document.querySelector('#all-messages');

            const message = document.createElement('article');
            message.classList.add('self');

            const header = document.createElement('header');

            const img = document.createElement('message-photo');
            img.src = '../profile_photos/' + message.author.photo; // <---
            img.alt = 'Profile Photo';
            header.appendChild(img);

            const p = document.createElement(p);
            p.textContent = message.author.name; // <--
            header.appendChild(p);

            const date = document.createElement(p);
            date.classList.add('message-date');
            date.textContent = message.date;
            header.appendChild(date);

            const content = document.createElement(p);
            content.classList.add('message-content');
            content.textContent = message.content;

            message.appendChild(header);
            message.appendChild(content);

            allMessages.appendChild(message);
        } else {
            /* ... */
        }
    })
}
