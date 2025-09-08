// Add this script after your jQuery main.js
document.querySelectorAll('input[name="role"]').forEach(function(radio) {
  radio.addEventListener('change', function() {
    const studentFields = document.getElementById('student-fields');
    const teacherFields = document.getElementById('teacher-fields');
    if (this.value === 'student') {
      studentFields.style.display = 'block';
      teacherFields.style.display = 'none';
    } else {
      studentFields.style.display = 'none';
      teacherFields.style.display = 'block';
    }
  });
});
// Initialize on page load depending on default selection
window.addEventListener('DOMContentLoaded', function() {
  let selectedRole = document.querySelector('input[name="role"]:checked').value;
  document.getElementById('student-fields').style.display = selectedRole === "student" ? "block" : "none";
  document.getElementById('teacher-fields').style.display = selectedRole === "teacher" ? "block" : "none";
});
