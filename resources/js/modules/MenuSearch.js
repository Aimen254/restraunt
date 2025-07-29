export class MenuSearch {
  constructor() {
    this.searchInput = document.querySelector('#menu-search');
    if (this.searchInput) {
      this.initSearch();
    }
  }

  initSearch() {
    this.searchInput.addEventListener('input', this.debounce(this.searchItems.bind(this), 300));
  }

  async searchItems() {
    const searchTerm = this.searchInput.value.toLowerCase();
    
    // Client-side search first
    this.clientSideSearch(searchTerm);
    
    // Optional: Uncomment if you want server-side search
    // if(searchTerm.length > 2) {
    //   await this.serverSideSearch(searchTerm);
    // }
  }

  clientSideSearch(term) {
    const menuItems = document.querySelectorAll('.menu-item');
    const categories = document.querySelectorAll('.menu-category');

    menuItems.forEach(item => {
      const name = item.dataset.name;
      const description = item.dataset.description;
      
      if (name.includes(term) || description.includes(term)) {
        item.style.display = 'flex';
      } else {
        item.style.display = 'none';
      }
    });

    categories.forEach(category => {
      const visibleItems = category.querySelectorAll('.menu-item[style="display: flex;"]');
      category.style.display = visibleItems.length > 0 ? 'block' : 'none';
    });
  }

  async serverSideSearch(term) {
    try {
      const response = await fetch(`/menu/search?q=${term}`);
      if (!response.ok) throw new Error('Network response was not ok');
      
      const html = await response.text();
      document.getElementById('menu-container').innerHTML = html;
    } catch (error) {
      console.error('Error during search:', error);
    }
  }

  debounce(func, wait) {
    let timeout;
    return function() {
      const context = this;
      const args = arguments;
      clearTimeout(timeout);
      timeout = setTimeout(() => {
        func.apply(context, args);
      }, wait);
    };
  }
}