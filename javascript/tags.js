const input = document.querySelector('#tags');

let dbtags = [];

window.onload = async () => {
    const url = '../api/api_tags.php';
    const response = await fetch(url);
    const allTags = await response.json();
    dbtags = allTags.map(tag => tag.name).filter(Boolean);
};

if (input) {
    input.addEventListener('keydown', async function (event) {
        if (event.key === 'Tab') {
            event.preventDefault();
            if (matchingTags.length > 0) {
                input.value = matchingTags[index];
                index = (index + 1) % matchingTags.length;
            }
        }

        if (event.key === 'Enter') {
            event.preventDefault();
            const tagName = input.value;

            for (const tag of dbtags) {
                if(tag === tagName) {
                    input.value = "";
                    return;
                }
            }

            const button = document.createElement('button');
            button.formAction = '../actions/action_delete_ticket_tag.php';
            button.formMethod = 'post';
            button.classList.add('all-tags');
            button.name = 'name';
            button.textContent = tagName;

            const section = document.querySelector('#property-tag');
            section.insertBefore(button, input);
    
            const url = '../api/api_tags.php/';
            const data = { name: tagName };
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: encodeForAjax(data),
            })
    
            const success = await response.json();
    
            if (success) {
                dbtags.push(tagName);
                const id = document.querySelector('#id');
                const url = '../api/api_ticket.php';
                const data = {id: id.value, tag: tagName};
                const response = await fetch(url, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: encodeForAjax(data),
                });
            }

            input.value = "";
        }
    })

    let matchingTags = [];
    let index = 0;

    input.addEventListener('input',  function (event) {
        const tag = input.value.toUpperCase();

        if (tag === '') {
            return;
        }

        matchingTags = dbtags.filter(dbtag => dbtag && dbtag.toUpperCase().startsWith(tag)).filter(Boolean);
    });
}
