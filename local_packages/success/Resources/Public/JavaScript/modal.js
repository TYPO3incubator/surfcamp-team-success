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
        modalContent.innerHTML = responseHtml;
        const responseForm = modalContent.querySelector('form');
        if (responseForm) {
          responseForm.addEventListener('submit', (responseEvent) => {
            handleForm(responseEvent, responseForm, modalContent, cid)
          });
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
  const modalContent = document.getElementById('modal-content');
  const loadingIndicator = document.getElementById('loading-indicator');

  // Show loading indicator
  loadingIndicator.style.display = 'block';

  // Load content from href of the clicked link
  fetch(link.href)
    .then(response => response.text())
    .then(html => {
      modalContent.innerHTML = html;

      // Search for element with the same id as cid in the modal content
      const elementInModal = modalContent.querySelector(`#c${cid}`);

      if (elementInModal) {
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
