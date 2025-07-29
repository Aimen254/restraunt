// resources/js/modules/AuthManager.js
export class AuthManager {
  constructor() {
    this.initAuthEvents();
  }

  initAuthEvents() {
    // Login form validation
    document.querySelectorAll('.auth-form').forEach(form => {
      form.addEventListener('submit', this.validateAuthForm.bind(this));
    });
  }

  validateAuthForm(e) {
    const email = e.target.querySelector('input[name="email"]');
    const password = e.target.querySelector('input[name="password"]');
    
    if (!email.value || !password.value) {
      e.preventDefault();
      this.showError('Please fill all fields');
    }
  }

  showError(message) {
    const errorEl = document.createElement('div');
    errorEl.className = 'auth-error text-red-500 py-2';
    errorEl.textContent = message;
    document.querySelector('.auth-form').prepend(errorEl);
  }
}