// KONFIGURASI GLOBAL AXIOS
const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

axios.defaults.baseURL = "";
axios.defaults.headers.common["X-CSRF-TOKEN"] = csrfToken;
axios.defaults.headers.common["Accept"] = "application/json";
axios.defaults.headers.common["Content-Type"] = "application/json";

// =======================
// GET CART
// =======================
async function getCart() {
    try {
        const response = await axios.get("/cart");

        console.log("GET CART:", response.data);

        if (!response.data || !response.data.data) return;

        const cart = response.data.data;

        updateCartCount(cart);
        updateCartPreview(cart);

        return cart;
    } catch (error) {
        console.log("GET CART ERROR (IGNORE):", error);
        // ❗ jangan pernah kasih notif di sini
    }
}

// =======================
// ADD TO CART
// =======================
async function addToCart(productId, quantity = 1) {
    try {
        const response = await axios.post("/cart/add", {
            product_id: productId,
            quantity: quantity,
        });

        console.log("ADD RESPONSE:", response.data);

        // VALIDASI DATA
        if (!response.data || !response.data.data) {
            throw new Error("Invalid response");
        }

        showNotification(
            response.data.message || "Item added to cart",
            "success",
        );

        // update UI
        updateCartCount(response.data.data);
        updateCartPreview(response.data.data);

        return response.data.data;
    } catch (error) {
        console.error("ADD ERROR:", error);

        // ❗ cuma tampilkan error kalau memang dari server
        if (error.response) {
            showNotification(
                error.response.data.message || "Failed to add item",
                "error",
            );
        }
    }
}

// =======================
// UPDATE QUANTITY
// =======================
async function updateQuantity(cartItemId, quantity) {
    // jika quantity 0, hapus item
    if (!quantity) {
        return removeItem(cartItemId);
    }
    try {
        const response = await axios.patch(`/cart/items/${cartItemId}`, {
            quantity: quantity,
        });

        showNotification(response.data.message, "success");
        updateCartCount(response.data.data);
        updateCartPreview(response.data.data);
        return response.data.data;
    } catch (error) {
        if (error.response && error.response.status === 422) {
            showNotification(error.response.data.message, "error");
        } else {
            showNotification("Failed to update quantity", "error");
        }
    }
}

// =======================
// REMOVE ITEM
// =======================
async function removeItem(cartItemId) {
    try {
        const response = await axios.delete(`/cart/items/${cartItemId}`);
        showNotification(response.data.message, "success");
        updateCartCount(response.data.data);
        updateCartPreview(response.data.data);
        return response.data.data;
    } catch (error) {
        console.log(error);
        showNotification("Failed to remove item", "error");
    }
}

// =======================
// UPDATE CART PREVIEW
// =======================
function updateCartPreview(cart) {
    const preview = document.getElementById("cart-preview");

    if (!preview) return;

    if (!cart || !cart.items || !cart.items.length) {
        preview.innerHTML = "<p>Cart is empty.</p>";
        return;
    }

    let html = "";

    cart.items.forEach((item) => {
        if (!item.product) return;

        html += `
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
            <span>${item.product.name}</span>
            <div style="display:flex;align-items:center;gap:4px">
                <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                <span>${item.quantity}</span>
                <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                <button onclick="removeItem(${item.id})" style="color:red">✕</button>
            </div>
        </div>`;
    });

    html += `
    <hr>
    <div style="display:flex;justify-content:space-between;margin-top:8px">
        <strong>Total</strong>
        <strong>Rp ${Number(cart.total || 0).toLocaleString("id-ID")}</strong>
    </div>`;

    preview.innerHTML = html;
}

// =======================
// HELPER: UPDATE CART COUNT
// =======================
function updateCartCount(cartData) {
    const cartCount = document.getElementById("cart-count");
    if (cartCount && cartData) {
        cartCount.textContent = cartData.total_items ?? 0;
    }
}

// =======================
// HELPER: SHOW NOTIFICATION
// =======================
function showNotification(message, type = "success") {
    alert(`[${type.toUpperCase()}] ${message}`);
}

// =======================
// INIT
// =======================
document.addEventListener("DOMContentLoaded", function () {
    getCart();
});
