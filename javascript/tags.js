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




if(input)
input.addEventListener('input',  async function (event) {
    event.preventDefault();
    const url = '../api/api_tags.php' 

    const response = await fetch(url);
    const allTags = await response.json();

    const dbtags = new Array();

    for(const tag of allTags) {
        dbtags.push(tag.name);
    }

    const tag = input.value;


    for (const i=0; i<dbtags.length; i++) {
        if (dbtags[i].toUpperCase().includes(tag.toUpperCase())) {
            const p = document.createElement('p');
            p.textContent = dbtags[i];
            
            //Attach click event to each paragraph
            p.addEventListener('keydown', function() {
                if (event.key === 'Tab')
                    input.value = dbtags[i];
            });
        }
    }
});

