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
        // tags ????
        const url = '../api/api_ticket.php/';
        const data = {id: id.value, status: status.value, priority: priority.value, department: department.value, agent: agent.value};
        const response = await fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: encodeForAjax(data),
        })
        const properties = await response.json();
        if (properties)
            alert('Ticket properties successfully edited');
        else
            alert('Some ticket properties could not be edited');
    })
}