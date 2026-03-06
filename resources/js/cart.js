// KONFIGURASI GLOBAL AXIOS
const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

axios.defaults.baseURL = "/api";
axios.defaults.headers.common["X-CSRF-TOKEN"] = csrfToken;
axios.defaults.headers.common["Accept"] = "application/json";
axios.defaults.headers.common["Content-Type"] = "application/json";

// fungsi get cart
async function getCart() {
    try {
        const response = await axios.get("/cart");
        updateCartCount(response.data.data);
        return response.data.data;
    } catch (error) {
        console.log("Gagal ambil cart:".error);
    }
}

// fungsi add to cart
async function addToCart() {
    try {
        const response = await axios.post("/cart/add", {
            product_id: productId,
            quantity: quantity,
        });

        showNotification(error.response.message, "success");
        updateCartCount(error.data.data);
        return response.data.data;
    } catch (error) {
        if (error.response && error.response.status === 422) {
            showNotification(error.response.data.message, 'error');
        } else {
            showNotification('Failed to add item', 'error');
        }
    }
}

// fungsi update quantity
async function updateQuantity(cartItemId, quantity){
    try{
        const response = await axios.patch(`/cart/items/${cartItemId}`, {
            quantity: quantity
        });

        showNotification(response.data.message, 'success');
        return response.data.data;
    }catch(error){
        if(error.response && error.response.status === 422){
            showNotification(error.response.data.message, 'error');
        }else{
            showNotification('Failed to update quantity', 'error');
        }
    }
}

// fungsi remove item
async function removeItem(cartItemId){
    try{
        const response = await axios.delete(`/cart/items/${cartItemId}`);

        showNotification(response.data.message, 'success');
        updateCartCount(response.data.data);
        return response.data.dara;
    }catch (error){
        showNotification('Failed to remove item', 'error');
    }
}

// helper
function updateCartCount(cartData){
    const cartCount = document.getElementById('cart-count');
    if(cartCount && cartData){
        cartCount.textContent = cartData.total_items ?? 0;
    }
}

function showNotification(message, type = "success"){
    alert(`[${type.toUpperCase}] ${message}`);
}