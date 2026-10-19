/**
 * CodeX404 Solutions — Form Interaction & Validation Engine
 * Handles asynchronous submission, inline feedback, and spinner states.
 */

document.addEventListener('DOMContentLoaded', () => {
  const ajaxForms = document.querySelectorAll('.ajax-form');

  ajaxForms.forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const submitBtn = form.querySelector('button[type="submit"]');
      const alertContainer = form.querySelector('.form-alert-container');
      const originalBtnHtml = submitBtn ? submitBtn.innerHTML : 'Submit';

      // Reset prior error states
      form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
      form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
      if (alertContainer) alertContainer.innerHTML = '';

      // Set loading state
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
          <svg style="animation: spin 1s linear infinite; width: 18px; height: 18px; vertical-align: middle; margin-right: 8px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="12" cy="12" r="10" stroke-width="4" stroke="currentColor" stroke-dasharray="32" stroke-linecap="round"></circle>
          </svg>
          Processing...
        `;
      }

      const formData = new FormData(form);

      try {
        const response = await fetch(form.action || window.location.href, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        const result = await response.json();

        if (result.status === 'success') {
          if (alertContainer) {
            alertContainer.innerHTML = `
              <div class="alert-box alert-success" role="alert">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <div>
                  <strong>Success!</strong> ${result.message}
                  ${result.ref ? `<div style="font-size: 0.8rem; margin-top: 4px; opacity: 0.85;">Reference Code: ${result.ref}</div>` : ''}
                </div>
              </div>
            `;
          }
          form.reset();
        } else {
          // Display validation errors
          if (result.errors) {
            let firstInvalidField = null;
            Object.keys(result.errors).forEach(fieldName => {
              const field = form.querySelector(`[name="${fieldName}"]`);
              if (field) {
                const uniqueErrorId = 'error-' + fieldName + '-' + Math.floor(Math.random() * 10000);
                field.classList.add('is-invalid');
                field.setAttribute('aria-invalid', 'true');
                field.setAttribute('aria-describedby', uniqueErrorId);
                if (!firstInvalidField) firstInvalidField = field;
                const errorMsg = document.createElement('div');
                errorMsg.className = 'invalid-feedback';
                errorMsg.id = uniqueErrorId;
                errorMsg.innerText = result.errors[fieldName];
                field.parentNode.appendChild(errorMsg);
              }
            });
            if (firstInvalidField) {
              firstInvalidField.focus();
            }
          }

          if (alertContainer) {
            alertContainer.innerHTML = `
              <div class="alert-box alert-danger" role="alert">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <div>${result.message || 'An error occurred during submission. Please check the fields and try again.'}</div>
              </div>
            `;
          }
        }
      } catch (err) {
        if (alertContainer) {
          alertContainer.innerHTML = `
            <div class="alert-box alert-danger" role="alert">
              <div>Network or server error. Please email us directly at <strong>contact@codex404solutions.online</strong>.</div>
            </div>
          `;
        }
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalBtnHtml;
        }
      }
    });
  });
});
