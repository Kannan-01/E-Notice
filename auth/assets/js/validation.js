document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('.signup-form');
  const studentFields = document.getElementById('student-fields');
  const teacherFields = document.getElementById('teacher-fields');

  const roleRadios = document.querySelectorAll('input[name="role"]');
  roleRadios.forEach(radio => {
    radio.addEventListener('change', () => {
      if (radio.value === 'student' && radio.checked) {
        studentFields.style.display = 'block';
        teacherFields.style.display = 'none';
      } else if (radio.value === 'teacher' && radio.checked) {
        studentFields.style.display = 'none';
        teacherFields.style.display = 'block';
      }
    });
  });

  // Create toast container if it doesn't exist
  if (!document.getElementById('toast-container')) {
    const toastContainer = document.createElement('div');
    toastContainer.id = 'toast-container';
    toastContainer.className = 'position-fixed top-0 end-0 p-3';
    toastContainer.style.zIndex = '1100';
    document.body.appendChild(toastContainer);
  }

  function showToast(message) {
    const toastContainer = document.getElementById('toast-container');
    const toastId = 'validationToast' + Date.now();

    const toastHTML = `
      <div id="${toastId}" class="toast bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
        <div class="d-flex">
          <div class="toast-body">${message}</div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>`;

    toastContainer.insertAdjacentHTML('beforeend', toastHTML);

    const toastElement = document.getElementById(toastId);
    const bsToast = new bootstrap.Toast(toastElement);
    bsToast.show();

    // Automatically remove toast from DOM after hidden
    toastElement.addEventListener('hidden.bs.toast', () => {
      toastElement.remove();
    });
  }

  form.addEventListener('submit', (e) => {
    let errors = [];

    // Name validation (alphabets and spaces, min 2 chars)
    const name = form.name.value.trim();
    if (!/^[A-Za-z ]{2,}$/.test(name)) {
      errors.push('Name must be at least 2 characters long and contain only letters and spaces.');
    }

    // Email validation
    const email = form.email.value.trim();
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i;
    if (!emailPattern.test(email)) {
      errors.push('Please enter a valid email address.');
    }

    // Password validation (min 6 chars, at least 1 uppercase, 1 special char)
    const password = form.pass.value;
    if (!/^(?=.*[A-Z])(?=.*[\W_]).{6,}$/.test(password)) {
      errors.push('Password must be at least 6 characters with 1 uppercase letter and 1 special character.');
    }

    // Contact validation (exactly 10 digits)
    const contact = form.contact.value.trim();
    if (!/^\d{10}$/.test(contact)) {
      errors.push('Contact must be exactly 10 digits.');
    }

    // Role-specific ID validation (6 digits)
    if (form.role.value === 'student') {
      const studentId = form.student_id.value.trim();
      if (!/^\d{6}$/.test(studentId)) {
        errors.push('Student ID must be exactly 6 digits.');
      }
    } else if (form.role.value === 'teacher') {
      const employeeId = form.employee_id.value.trim();
      if (!/^\d{6}$/.test(employeeId)) {
        errors.push('Employee ID must be exactly 6 digits.');
      }
    }

    if (errors.length > 0) {
      e.preventDefault();
      // Show each validation error as separate toast
      errors.forEach(err => showToast(err));
    }
  });
});
