// set up Axios CSRF TOKEN wajib disemua file js
axios.defaults.headers.common["X-CSRF-TOKEN"] = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

// ============================================================
// ALPINE COMPONENT — Product Manager
// Satu component ini handle semua operasi CRUD produk
// ============================================================

function productManager() {
    return {
        // === STATE ===
        loading: false,
        message: "",
        isError: false,

        // === DELETE PRODUCT ===
        async deleteProduct(productId, rowElement) {
            // rowElement → elemen <tr> yang akan kita hapus dari DOM
            // Daripada reload halaman, lebih smooth hapus row-nya langsung

            if (!confirm("Are you sure about deleting this?")) return;
            // kalau user cancel confirm dialog, stop disini

            this.loading = true;

            try {
                const response = await axios.delete(
                    "/admin/products/${productId}",
                );

                if (response.data.status) {
                    this.showNotif(response.data.message, false);
                    rowElement.remove();
                    // Hapus baris tabel dari DOM tanpa reload halaman
                }
            } catch (error) {
                this.showNotif(
                    error.response?.data?.message ?? 'Product Deletion Failed',
                    true
                )
            }
            this.loading = false;
        },

        // ===== TOGGLE IS_ACTIVE =====
        async toggleActive(productId, currentStatus){
            // Tombol toggle aktif/nonaktif produk langsung dari tabel
            // Ga perlu buka halaman edit hanya untuk ubah status

            try{
                const response = await axios.patch(`/admin/products/${productId}/toggle-active`, {
                    is_active: !currentStatus
                    // kirim kebalikan dari sekarang
                });

                if(response.data.status){
                    this.showNotif(response.data.message, false);
                    return response.data.data.is_active;
                    // return status terbaru supaya alpine bisa update tampilannya
                }
            }catch(error){
                this.showNotif(response?.data?.message ?? 'Failed To Update!',
                    true
                );
            }
        },

        // === HELPER ===
        showNotif(msg, error = false){
            this.message = msg;
            this.isError = error;

            // notif otomatis hilang 3 detik
            setTimeout(() => {
                this.message = '',
                this.isError = false;
            }, 3000);
        }
    }
}
