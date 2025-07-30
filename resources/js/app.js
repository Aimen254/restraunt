// In your main app.js
import { CartManager } from './modules/CartManager';
import { MenuSearch } from './modules/MenuSearch';
import { AuthManager } from './modules/AuthManager';
import { ReservationManager } from './modules/ReservationManager';
import { OrderManager } from './modules/OrderManager';

document.addEventListener('DOMContentLoaded', () => {
  const managers = [];
  
  if (document.querySelector('.auth-form')) {
    managers.push(new AuthManager());
  }
  
  if (document.querySelector('.add-to-cart-form')) {
    managers.push(new CartManager());
  }

  if (document.querySelector('#menu-search')) {
    managers.push(new MenuSearch());
  }

  if (document.querySelector('.cancel-reservation') || document.getElementById('reservation_date')) {
    managers.push(new ReservationManager());
  }
    if (document.querySelector('.orders-list-container')) {
        managers.push(new OrderManager());
    }
  // Track total AJAX calls across all managers
  setInterval(() => {
    const totalAjax = managers.reduce((sum, mgr) => sum + (mgr.ajaxCount || 0), 0);
    console.log(`Total AJAX calls: ${totalAjax}`);
  }, 1000);
});