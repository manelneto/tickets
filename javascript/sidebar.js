const filters = document.querySelector('.filters');
const controller = document.getElementById('controller');

if(controller)
  controller.addEventListener('click', function() {
      filters.classList.toggle('show');

      if(filters.classList.contains('show')) {
          controller.classList.add('move');
      }
      else {
          controller.classList.remove('move');
      }
    }
  );

const information = document.getElementById('information');
const tools = document.getElementById('tools');

tools.addEventListener('click', function() {
    information.classList.toggle('appear');

    if(information.classList.contains('appear')) {
      tools.classList.add('moving');
    }
    else {
      tools.classList.remove('moving');
    }
  }
);














