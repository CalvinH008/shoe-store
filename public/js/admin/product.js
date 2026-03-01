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
                    error.response?.data?.message ?? "Product Deletion Failed",
                    true,
                );
            }
            this.loading = false;
        },

        // ===== TOGGLE IS_ACTIVE =====
        async toggleActive(productId, currentStatus) {
            // Tombol toggle aktif/nonaktif produk langsung dari tabel
            // Ga perlu buka halaman edit hanya untuk ubah status

            try {
                const response = await axios.patch(
                    `/admin/products/${productId}/toggle-active`,
                    {
                        is_active: !currentStatus,
                        // kirim kebalikan dari sekarang
                    },
                );

                if (response.data.status) {
                    this.showNotif(response.data.message, false);
                    return response.data.data.is_active;
                    // return status terbaru supaya alpine bisa update tampilannya
                }
            } catch (error) {
                this.showNotif(
                    response?.data?.message ?? "Failed To Update!",
                    true,
                );
            }
        },

        // === HELPER ===
        showNotif(msg, error = false) {
            this.message = msg;
            this.isError = error;

            // notif otomatis hilang 3 detik
            setTimeout(() => {
                ((this.message = ""), (this.isError = false));
            }, 3000);
        },
    };
}

function productCreate() {
    return {
        loading: false,
        message: "",

        // semua data diambil dari sini
        form: {
            category_id: "",
            name: "",
            slug: "",
            price: "",
            stock: "",
            description: "",
            is_active: true,
            primary_image: 0,
        },

        images: [],
        previews: [],

        generateSlug() {
            this.form.slug = this.form.name
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, "")
                .replace(/\s+/g, "-")
                .replace(/-+/g, "-");
        },

        handleImages(event) {
            const files = Array.from(event.target.files);
            this.images = files;
            this.previews = files.map((file) => URL.createObjectURL(file));
        },

        async submitForm() {
            this.loading = true;
            const formData = new FormData();

            formData.append("category_id", this.form.category_id);
            formData.append("name", this.form.name);
            formData.append("slug", this.form.slug);
            formData.append("price", this.form.price);
            formData.append("stock", this.form.stock);
            formData.append("description", this.form.description);
            formData.append("is_active", this.form.is_active ? 1 : 0);
            formData.append("primary_image", this.form.primary_image);

            this.images.forEach((image) => {
                formData.append("images[]", image);
            });

            try {
                const response = await axios.post("/admin/products", formData, {
                    headers: { "Content-type": "multipart/form-data" },
                });

                if (response.data.status) {
                    this.message = response.data.message;
                    setTimeout(() => {
                        window.location.href = "/admin/products";
                    }, 1000);
                }
            } catch (error) {
                if(error.response?.status === 422){
                    const errors = error.response.data.errors;
                    this.message = Object.values(errors).flat().join(', ');
                }else{
                    this.message = error.response?.data.message ?? 'Something Went Wrong!';
                }
            }

            this.loading = false;
        },
    };
}
