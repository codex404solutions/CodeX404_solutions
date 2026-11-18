/**
 * CodeX404 Solutions — Form Interaction & Validation Engine
 * Handles asynchronous submission, inline feedback, and spinner states.
 */

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('form').forEach(form => {
    const divisionSelect = form.querySelector('[name="division"]');
    const serviceSelect = form.querySelector('[name="service"], [name="service_interest"]');
    if (!divisionSelect || !serviceSelect) return;

    const serviceGroups = Array.from(serviceSelect.querySelectorAll('optgroup[data-division]'));
    if (!serviceGroups.length) return;

    const updateServices = () => {
      const division = divisionSelect.value.toUpperCase();
      serviceGroups.forEach(group => {
        group.disabled = group.dataset.division !== division;
      });

      const selectedOption = serviceSelect.selectedOptions[0];
      const selectedGroup = serviceGroups.find(group => selectedOption && group.contains(selectedOption));
      if (selectedGroup && selectedGroup.disabled) serviceSelect.value = '';
    };

    divisionSelect.addEventListener('change', updateServices);
    form.addEventListener('reset', () => requestAnimationFrame(updateServices));
    updateServices();
  });

  const ajaxForms = document.querySelectorAll('.ajax-form');

  ajaxForms.forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const submitBtn = form.querySelector('button[type="submit"]');
      const alertContainer = form.querySelector('.form-alert-container');
      const originalBtnHtml = submitBtn ? submitBtn.innerHTML : 'Submit';

      // Reset prior error states
      form.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
        el.removeAttribute('aria-invalid');
        el.removeAttribute('aria-describedby');
      });
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
            const alert = document.createElement('div');
            alert.className = 'alert-box alert-success';
            alert.setAttribute('role', 'alert');
            const message = document.createElement('div');
            const heading = document.createElement('strong');
            heading.textContent = 'Success! ';
            message.append(heading, document.createTextNode(String(result.message || 'Your request was received.')));
            alert.appendChild(message);
            if (result.ref) {
              const reference = document.createElement('div');
              reference.style.cssText = 'font-size: 0.8rem; margin-top: 4px; opacity: 0.85;';
              reference.textContent = `Reference Code: ${String(result.ref)}`;
              alert.appendChild(reference);
            }
            alertContainer.replaceChildren(alert);
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
            const alert = document.createElement('div');
            alert.className = 'alert-box alert-danger';
            alert.setAttribute('role', 'alert');
            alert.textContent = String(result.message || 'An error occurred during submission. Please check the fields and try again.');
            alertContainer.replaceChildren(alert);
          }
        }
      } catch (err) {
        if (alertContainer) {
          alertContainer.innerHTML = `
            <div class="alert-box alert-danger" role="alert">
              <div>Network or server error. Please email us directly at <strong>info@codex404solutions.com</strong>.</div>
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
