document.addEventListener('DOMContentLoaded', function() {
    const refreshButtons = document.querySelectorAll('#refresh-captcha, .refresh-captcha');

    refreshButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const container = button.closest('.captcha-wrapper');
            const captchaImage = container?.querySelector('img');

            // Disable button and show loading state
            button.disabled = true;
            const icon = button.querySelector('i');
            if (icon) {
                icon.classList.add('fa-spin');
            }

            // Fetch new CAPTCHA image
            fetch('/captcha/default?' + Math.random())
                .then(response => response.blob())
                .then(blob => {
                    if (captchaImage) {
                        captchaImage.src = URL.createObjectURL(blob);
                    }
                    // Clear the input field
                    const input = container?.closest('form')?.querySelector('input[name="captcha"]');
                    if (input) {
                        input.value = '';
                    }
                })
                .catch(error => {
                    console.error('Error refreshing CAPTCHA:', error);
                })
                .finally(() => {
                    // Re-enable button and remove loading state
                    button.disabled = false;
                    if (icon) {
                        icon.classList.remove('fa-spin');
                    }
                });
        });
    });
});
