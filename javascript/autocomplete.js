function autocomplete(){

    const input = document.getElementById('tags');
    let suggestedTag = '';

    input.addEventListener('input', function(event) {
    const userInput = event.target.value.toLowerCase();
    const options = document.getElementById('tags-list').getElementsByTagName('option');

    suggestedTag = '';

    for (let i = 0; i < options.length; i++) {
      const optionValue = options[i].value.toLowerCase();

      if (optionValue.startsWith(userInput)) {
        suggestedTag = options[i].value;
        break;
      }
    }
  });

  input.addEventListener('keydown', function(event) {
    if (event.key === 'Tab') {
      event.preventDefault();
      if (suggestedTag !== '') {
        input.value = suggestedTag;
      }
    }
  });
}

autocomplete();