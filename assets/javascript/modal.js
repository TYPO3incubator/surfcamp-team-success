import '../scss/components/_modal.scss'
import '../scss/components/_notify.scss'

// Function to open modal and load content
const handleForm = (event, form, modalContent, cid) => {
  event.preventDefault();
  const submitButton = event.submitter; // Get the clicked submit button
  const submitValue = submitButton.value;
  const submitName = submitButton.name;
  const formData = new FormData(form),
    formId = form.id;
  formData.append(submitName, submitValue);
  fetch(form.action, {
    method: form.method,
    body: formData
  })
    .then(response => response.text())
    .then(responseHtml => {
      const responseElement = document.createElement('div');
      responseElement.innerHTML = responseHtml;
      const responseContent = responseElement.querySelector(`#${formId}`);

      if (responseContent) {
        modalContent.innerHTML = responseContent.innerHTML;
        const hasNotification = showNotification(modalContent);
        if(!hasNotification) {
          const responseForm = modalContent.querySelector('form');
          if (responseForm) {
            responseForm.addEventListener('submit', (responseEvent) => {
              handleForm(responseEvent, responseForm, modalContent, cid)
            });
          }
        }
      } else {
        console.error(`Element with id ${cid} not found in response.`);
      }
    })
    .catch(error => console.error('Error submitting form:', error));
}
const openModal = (link) => {
  const cid = link.getAttribute('data-cid');
  const modal = document.getElementById('modal');
  const loadingIndicator = document.getElementById('loading-indicator');
  let modalContent = document.getElementById('modal-content');

  // Show loading indicator
  loadingIndicator.style.display = 'block';

  // Load content from href of the clicked link
  fetch(link.href)
    .then(response => response.text())
    .then(html => {
      modalContent.innerHTML = html;

      // Search for element with the same id as cid in the modal content
      const elementInModal = modalContent.querySelector(`#c${cid}`);
      if(elementInModal) {
        modalContent.innerHTML = elementInModal.innerHTML;
        if (modalContent) {
          // Display modal
          modal.style.display = 'block';
          document.body.classList.add('modal-open'); // Prevent scrolling on background
          loadingIndicator.style.display = 'none'; // Hide loading indicator

          // Handle form submission if form exists in modal content
          const form = modalContent.querySelector('form');
          if (form) {
            form.addEventListener('submit', (event) => {
              handleForm(event, form, modalContent, cid)
            });
          }
        } else {
          console.error(`Element with id ${cid} not found in modal content.`);
        }
      }
    })
    .catch(error => console.error('Error loading content:', error));
};

document.addEventListener('DOMContentLoaded', () => {
  // Get all links with data-cid attribute
  const links = document.querySelectorAll('[data-cid]');

  // Attach click event listener to each link
  links.forEach(link => {
    link.addEventListener('click', (event) => {
      event.preventDefault();
      openModal(link);
    });
  });

  // Close modal when clicking outside of it
  const modal = document.getElementById('modal');
  modal.addEventListener('click', (event) => {
    if (event.target === modal) {
      modal.style.display = 'none';
      document.body.classList.remove('modal-open'); // Allow scrolling on background
    }
  });
});

const showNotification = (modalContent) => {

  const notificationElement = modalContent.querySelector('[data-notify]');
  // Get the notification div
  if (notificationElement) {
    // Close any open modal
    const modal = document.querySelector('.modal');
    if (modal) {
      modal.style.display = 'none';
    }
    // Show the notification
    const notification = notificationElement.cloneNode();
    notification.textContent = notificationElement.getAttribute('data-notify-text');;
    notification.style.display = 'block';
    document.body.appendChild(notification);

    // Close the notification after 5 seconds
    setTimeout(() => {
      notification.style.display = 'none';
      document.body.removeChild(notification);
    }, 3000);
    return true;
  }
  else {
    return false;
  }
};
