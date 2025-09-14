function validateNoticeForm() {
  const form = document.getElementById('noticeForm'); // Use your form's id
  const title = form.title.value.trim();
  const description = form.description.value.trim();
  const department = form.department.value;
  const validFrom = form.valid_from.value;
  const validUntil = form.valid_until.value;
  const target = form.target.value;

  if (!title) {
    alert("Please enter a title.");
    form.title.focus();
    return false;
  }
  if (!description) {
    alert("Please enter a description.");
    form.description.focus();
    return false;
  }
  if (!department) {
    alert("Please select a department.");
    form.department.focus();
    return false;
  }
  if (!validFrom) {
    alert("Please enter a valid 'Valid From' date.");
    form.valid_from.focus();
    return false;
  }
  if (!validUntil) {
    alert("Please enter a valid 'Valid Until' date.");
    form.valid_until.focus();
    return false;
  }
  if (new Date(validFrom) > new Date(validUntil)) {
    alert("'Valid From' date cannot be after 'Valid Until' date.");
    form.valid_from.focus();
    return false;
  }
  if (!target) {
    alert("Please select a target audience.");
    form.target.focus();
    return false;
  }
  
  // All passed - allow form submission
  return true;
}
