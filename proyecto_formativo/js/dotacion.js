function searchProducts() {
    const searchValue = document.getElementById('searchInput').value.toLowerCase();
    const products = document.querySelectorAll('.product-card');
    let found = false;

    products.forEach(product => {
        const productName = product.querySelector('h3').textContent.toLowerCase();
        if (productName.includes(searchValue)) {
            product.style.display = 'block'; 
            product.querySelector('img').style.display = 'block'; 
            found = true;
        } else {
            product.style.display = 'none';
        }
    });

    const productGrid = document.getElementById('productGrid');
    const noResultsMessage = document.querySelector('.no-results');

    if (!found) {
        if (!noResultsMessage) {
            const message = document.createElement('div');
            message.className = 'no-results';
            message.textContent = 'No se encontraron productos.';
            productGrid.appendChild(message);
        }
    } else {
        if (noResultsMessage) {
            noResultsMessage.remove();
        }
    }
}

function searchCategory(category) {
    const searchInput = document.getElementById('searchInput');
    searchInput.value = category; 
    searchProducts(); 
}