export class ReservationManager {
    constructor() {
        this.ajaxCount = 0;
        this.initEventHandlers();
    }

    initEventHandlers() {
        // Cancel reservation buttons
        document.querySelectorAll('.cancel-reservation').forEach(button => {
            button.addEventListener('click', (e) => this.handleCancelReservation(e));
        });

        // Create form handlers (if on create page)
        if (document.getElementById('reservation_date')) {
            document.getElementById('party_size').addEventListener('change', (e) => {
                this.handlePartySizeChange(e.target.value);
            });
            
            document.querySelector('form').addEventListener('submit', (e) => {
                this.handleFormSubmit(e);
            });
        }
    }

    handlePartySizeChange(size) {
        const tableSelect = document.getElementById('table_id');
        if (!tableSelect) return;

        Array.from(tableSelect.options).forEach(option => {
            if (option.value) {
                // Extract capacity from option text (e.g. "Table #1 (4 people)")
                const capacityMatch = option.text.match(/\((\d+) people\)/);
                if (capacityMatch) {
                    const capacity = parseInt(capacityMatch[1]);
                    option.disabled = capacity < size;
                }
            }
        });
    }

    async handleCancelReservation(event) {
        event.preventDefault();
        const form = event.target.closest('form');
        
        if (!confirm('Are you sure you want to cancel this reservation?')) {
            return;
        }

        this.ajaxCount++;
        try {
            const response = await fetch(form.action, {
                method: 'POST', // Laravel needs POST for DELETE via method spoofing
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                    'X-HTTP-Method-Override': 'DELETE',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ _method: 'DELETE' })
            });

            if (response.ok) {
                const reservationItem = form.closest('.border-b');
                reservationItem.remove();
                
                this.showFlashMessage('Reservation cancelled successfully', 'success');
                
                if (!document.querySelector('.border-b')) {
                    window.location.reload();
                }
            } else {
                const error = await response.json();
                throw new Error(error.message || 'Failed to cancel');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showFlashMessage(error.message || 'Failed to cancel reservation', 'error');
        } finally {
            this.ajaxCount--;
        }
    }

    async handleFormSubmit(event) {
        event.preventDefault();
        const form = event.target;
        
        this.ajaxCount++;
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                window.location.href = '/reservations';
            } else {
                const errors = await response.json();
                this.showFormErrors(errors.errors);
            }
        } catch (error) {
            console.error('Error:', error);
            this.showFlashMessage('An error occurred', 'error');
        } finally {
            this.ajaxCount--;
        }
    }

    showFormErrors(errors) {
        // Clear previous errors
        document.querySelectorAll('.error-message').forEach(el => el.remove());
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

        // Show new errors
        for (const [field, messages] of Object.entries(errors)) {
            const input = document.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message text-red-500 text-sm mt-1';
                errorDiv.textContent = messages[0];
                input.parentNode.appendChild(errorDiv);
            }
        }
    }

    showFlashMessage(message, type = 'success') {
        const flashDiv = document.createElement('div');
        flashDiv.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white`;
        flashDiv.textContent = message;
        
        document.body.appendChild(flashDiv);
        
        setTimeout(() => {
            flashDiv.remove();
        }, 5000);
    }
}