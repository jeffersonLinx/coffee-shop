// scripts.js

// Inicializa el carrito: lee localStorage o crea uno vacío
function getCart() {
    return JSON.parse(localStorage.getItem('productos') || '[]');
  }
  
  // Guarda el carrito actualizado en localStorage
  function setCart(cart) {
    localStorage.setItem('productos', JSON.stringify(cart));
  }
  
  // Añade un producto (por id) al carrito
  function addToCart(id) {
    const cart = getCart();
    cart.push({ id });        // puedes ampliar con qty u otras propiedades
    setCart(cart);
    updateBadge();
  }
  
  // Vacía por completo el carrito
  function clearCart() {
    localStorage.removeItem('productos');
    updateBadge();
  }
  
  // Actualiza el número que se muestra en el botón flotante
  function updateBadge() {
    const cart = getCart();
    document.getElementById('carrito').textContent = cart.length;
  }
  
  // Cuando la página carga, conectamos los eventos y actualizamos la UI
  document.addEventListener('DOMContentLoaded', () => {
    // Botones "Agregar"
    document.querySelectorAll('.agregar').forEach(btn => {
      btn.addEventListener('click', () => addToCart(btn.dataset.id));
    });
  
    // Botón "Vaciar Carrito" (en carrito.php)
    const vaciarBtn = document.getElementById('btnVaciar');
    if (vaciarBtn) {
      vaciarBtn.addEventListener('click', () => {
        clearCart();
        // limpia la tabla y total en pantalla si estás en carrito.php
        document.getElementById('tblCarrito').innerHTML = '';
        document.getElementById('total_pagar').textContent = '0.00';
      });
    }
  
    // Siempre actualiza el contador al cargar
    updateBadge();
  });
  