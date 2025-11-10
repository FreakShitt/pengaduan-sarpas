// Minimal Login Form JavaScript
class MinimalLoginForm {
    constructor() {
        this.form = document.getElementById('loginForm');
        
        // Check if form exists (untuk halaman login/register)
        if (!this.form) {
            return;
        }
        
        this.usernameInput = document.getElementById('username');
        this.passwordInput = document.getElementById('password');
        this.passwordToggle = document.getElementById('passwordToggle');
        this.submitButton = this.form.querySelector('.login-btn');
        this.successMessage = document.getElementById('successMessage');
        
        this.init();
    }
    
    init() {
        this.setupPasswordToggle();
        // Tidak perlu validate, biarkan Laravel handle
    }
    
    bindEvents() {
        // Removed - biarkan form submit secara normal ke server
    }
    
    setupPasswordToggle() {
        if (this.passwordToggle && this.passwordInput) {
            this.passwordToggle.addEventListener('click', () => {
                const type = this.passwordInput.type === 'password' ? 'text' : 'password';
                this.passwordInput.type = type;
                
                const icon = this.passwordToggle.querySelector('.toggle-icon');
                if (icon) {
                    icon.classList.toggle('show-password', type === 'text');
                }
            });
        }
    }
}

// Initialize the form when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new MinimalLoginForm();
});