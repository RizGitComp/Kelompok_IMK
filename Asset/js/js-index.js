document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("password");
  const icon = document.getElementById("togglePassword");

  icon.addEventListener("click", () => {
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      input.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  });
});
