// // =======================
// // KONFIGURASI AXIOS
// // =======================
// const csrfToken = document
//     .querySelector('meta[name="csrf-token"]')
//     .getAttribute("content");

// axios.defaults.headers.common["X-CSRF-TOKEN"] = csrfToken;
// axios.defaults.headers.common["Accept"] = "application/json";

// // =======================
// // FUNCTION CHECKOUT
// // =======================
// async function checkout(event) {
//     event.preventDefault(); // cegah form submit default

//     const submitBtn = document.getElementById("checkout-submit");
//     submitBtn.disabled = true;
//     submitBtn.textContent = "Processing...";

//     // ambil semua value input
//     const formData = {
//         name: document.getElementById("name")?.value || "",
//         phone: document.getElementById("phone")?.value || "",
//         payment_method: document.getElementById("payment_method")?.value || "",
//         shipping_address:
//             document.getElementById("shipping_address")?.value || "",
//         notes: document.getElementById("notes")?.value || "",
//     };

//     try {
//         const response = await axios.post("/checkout", formData);

//         if (response.data.status) {
//             alert(response.data.message || "Order Placed Successfully");
//             window.location.href = response.data.data.redirect; // redirect ke success
//         } else {
//             alert(response.data.message || "Checkout Failed");
//         }
//     } catch (error) {
//         console.error(error);
//         if (error.response && error.response.data) {
//             alert(error.response.data.message || "Checkout Error");
//         } else {
//             alert("Checkout Error");
//         }
//     } finally {
//         submitBtn.disabled = false;
//         submitBtn.textContent = "Place Order";
//     }
// }

// const checkoutForm = document.getElementById("checkout-form");

// checkoutForm.addEventListener("submit", async function (e) {
//     e.preventDefault();

//     const data = {
//         name: this.name.value,
//         phone: this.phone.value,
//         payment_method: this.payment_method.value,
//         shipping_address: this.shipping_address.value,
//         notes: this.notes.value,
//     };

//     try {
//         const res = await axios.post("/checkout", data);
//         if (res.data.status) {
//             window.location.href = res.data.data.redirect;
//         }
//     } catch (err) {
//         alert(err.response?.data?.message || "Checkout failed");
//     }
// });

// const form = document.getElementById("checkoutForm");
// form.addEventListener("submit", async (e) => {
//     e.preventDefault();
//     const data = Object.fromEntries(new FormData(form).entries());
//     const res = await axios.post("/checkout", data);
//     if (res.data.status) window.location.href = res.data.data.redirect;
// });

// // =======================
// // EVENT LISTENER
// // =======================
// document.addEventListener("DOMContentLoaded", function () {
//     const checkoutForm = document.getElementById("checkout-form");
//     if (checkoutForm) {
//         checkoutForm.addEventListener("submit", checkout);
//     }
// });
