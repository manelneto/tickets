const input = document.querySelector('#tags');

if (input) {
    input.addEventListener('keydown', async function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const tag = input.value;

            const url = '../api/api_tags.php?' + encodeForAjax({input: input.value});

            const response = await fetch(url);
            const allTags = await response.json();

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

let dbtags = [];

window.onload = async () => {
    const url = '../api/api_tags.php';
    const response = await fetch(url);
    const allTags = await response.json();
    dbtags = allTags.map(tag => tag.name).filter(Boolean);
};

if(input) {
    let matchingTags = [];
    let index = 0;

    input.addEventListener('input',  function (event) {
        const tag = input.value.toUpperCase();

        if (tag === '') {
            return;
        }

        matchingTags = dbtags.filter(dbtag => dbtag && dbtag.toUpperCase().startsWith(tag)).filter(Boolean);
    });

    input.addEventListener('keydown', function(event) {
        if (event.key === 'Tab') {
            event.preventDefault();
            
            if (matchingTags.length > 0) {
                input.value = matchingTags[index];
                index = (index + 1) % matchingTags.length;
            }
        }
    });
}







