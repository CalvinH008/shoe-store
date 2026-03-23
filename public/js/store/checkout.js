// // =======================
// // KONFIGURASI AXIOS - Global axios from CDN
// // =======================
// document.addEventListener('DOMContentLoaded', function() {
//     const token = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : null;
//     if (token && axios) {
//         axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
//         axios.defaults.headers.common['Accept'] = 'application/json';
//         console.log('Axios CSRF configured OK');
//     }
// });

// // =======================
// // SUBMIT CHECKOUT - Place Order button handler
// // =======================
// async function submitCheckout(event) {
//     event.preventDefault();
    
//     const form = document.getElementById('checkoutForm
