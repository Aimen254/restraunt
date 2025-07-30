// resources/js/modules/OrderManager.js
export class OrderManager {
    constructor() {
        this.ajaxCount = 0;
        this.initEventHandlers();
    }

    initEventHandlers() {
        // Handle menu link click
        document.getElementById('ajax-orders-link')?.addEventListener('click', (e) => {
            e.preventDefault();
            this.loadOrders();
            
            // Update browser history
            history.pushState(null, '', e.target.href);
            
            // Update active state
            this.updateActiveNavLink(e.target);
        });

        // Pagination links
        document.querySelector('.pagination')?.addEventListener('click', (e) => {
            if (e.target.tagName === 'A') {
                e.preventDefault();
                this.loadOrders(e.target.href);
            }
        });
    }

      updateActiveNavLink(link) {
        // Remove active class from all nav items
        document.querySelectorAll('.nav-link').forEach(el => {
            el.classList.remove('bg-indigo-50', 'border-indigo-500', 'text-indigo-700');
            el.classList.add('border-transparent', 'text-gray-500', 'hover:bg-gray-50', 'hover:border-gray-300', 'hover:text-gray-700');
        });
        
        // Add active class to clicked link
        link.classList.add('bg-indigo-50', 'border-indigo-500', 'text-indigo-700');
        link.classList.remove('border-transparent', 'text-gray-500', 'hover:bg-gray-50', 'hover:border-gray-300', 'hover:text-gray-700');
    }
    async loadOrders(url = null) {
        this.ajaxCount++;
        try {
            const targetUrl = url || '/orders/ajax';
            const response = await fetch(targetUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                this.updateOrdersList(data.html);
                this.updatePagination(data.links);
            }
        } catch (error) {
            console.error('Error loading orders:', error);
        } finally {
            this.ajaxCount--;
        }
    }

    async loadOrderDetails(orderId) {
        this.ajaxCount++;
        try {
            const response = await fetch(`/orders/${orderId}/ajax`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                this.showOrderModal(data.html);
            }
        } catch (error) {
            console.error('Error loading order details:', error);
        } finally {
            this.ajaxCount--;
        }
    }

    updateOrdersList(html) {
        const container = document.querySelector('.orders-list-container');
        if (container) {
            container.innerHTML = html;
            // Re-attach event handlers to new elements
            document.querySelectorAll('.order-item').forEach(item => {
                item.addEventListener('click', (e) => {
                    if (e.target.tagName !== 'A') {
                        this.loadOrderDetails(item.dataset.orderId);
                    }
                });
            });
        }
    }

    updatePagination(links) {
        const paginationContainer = document.querySelector('.pagination-container');
        if (paginationContainer) {
            paginationContainer.innerHTML = links;
            // Re-attach event handler to new pagination links
            document.querySelector('.pagination')?.addEventListener('click', (e) => {
                if (e.target.tagName === 'A') {
                    e.preventDefault();
                    this.loadOrders(e.target.href);
                }
            });
        }
    }

    showOrderModal(html) {
        // Create or update modal with order details
        let modal = document.getElementById('order-details-modal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'order-details-modal';
            modal.className = 'fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50';
            modal.innerHTML = `
                <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="p-6">
                        <button class="modal-close absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <div class="modal-content"></div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            
            // Add close handler
            modal.querySelector('.modal-close').addEventListener('click', () => {
                modal.remove();
            });
        }
        
        modal.querySelector('.modal-content').innerHTML = html;
    }
}