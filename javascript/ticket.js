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
        console.log(success);
        let messages = document.querySelector('#messages');
        if (!messages) {
            messages = document.createElement('section');
            messages.id = 'messages';
        }
        const message = document.createElement('article');
        if (success) {
            message.classList.add('success');
            message.textContent = 'Ticket properties successfully edited';

            const url = '../api/api_change.php?' + encodeForAjax({id: id.value});
            const response = await fetch(url);
            const changes = await response.json();

            const details = document.querySelector('#changes');
            for (const change of changes) {
                h5 = document.createElement('h5');
                h5.textContent = change.date;
                details.appendChild(h5);
                p = document.createElement('p');
                p.textContent = change.description;
                details.appendChild(p);
            }
        } else {
            message.classList.add('error');
            message.textContent = 'Ticket properties could not be edited';
        }
        messages.appendChild(message);

        const body = document.querySelector('body');
        const main = document.querySelector('#ticket-page');
        body.insertBefore(messages, main);
    })
}

const option = document.querySelector('#faq-reply');
if (option) {
    option.addEventListener('change', async function (event) {
        const textarea = document.querySelector('#new-message');
        console.log(typeof(this.value));
        if (this.value === '0')
            textarea.value = '';
        else {
            const id = this.value;
            const url = '../api/api_faq.php?' + encodeForAjax({id: id});
            const response = await fetch(url);
            const faq = await response.json();
            textarea.value = faq.answer;
        }
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
            article.classList.add('self');

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

            allMessages.scrollTo(0, allMessages.scrollHeight);

            const textarea = document.querySelector('#new-message');
            textarea.value = '';
        } else {
            /* ... */
        }
    })
}

const editButton = document.getElementById('author-edit-button');
let isEditMode = false;

editButton.addEventListener('click', function(event) {
    if (isEditMode) {
        return;
      }

    event.preventDefault();
    editButton.textContent = 'Save';
    
    const EditHeader = document.getElementById('edit-header');
    EditHeader.style.backgroundColor = "#F0F0F0";

    const EditDescription = document.getElementById('description');
    EditDescription.style.backgroundColor = "#F0F0F0";

    isEditMode = true;
});


const showButton = document.getElementById('show-button');
const showMessages = document.getElementById('messageBoard');

showButton.addEventListener('click', function(){
    
    if (messageBoard.hasAttribute('open')) {
        messageBoard.removeAttribute('open');
        showButton.textContent = 'Show';
        showButton.style.background = "midnightblue";
    } else {
        messageBoard.setAttribute('open', 'open');
        showButton.textContent = 'Hide';
        showButton.style.background = "#7CB9E8";
    }

});


const messageInfo = document.querySelectorAll('#messages article.success');

messageInfo.forEach(function(element) {
  const duration = 7000;

  function removeMessageInfo() {
    element.remove();
  }

  setTimeout(removeMessageInfo, duration);
});
