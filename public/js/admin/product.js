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
        loading: false,
        message: "",
        isError: false,
        products: [],
        currentPage: 1,
        lastPage: 1,

        async fetchProducts(page = 1) {
            try {
                const response = await axios.get(
                    `/admin/products/data?page=${page}`,
                );
                this.products = response.data.data.data;
                this.currentPage = response.data.data.current_page;
                this.lastPage = response.data.data.last_page;
            } catch (error) {
                this.showNotif("Failed to load products.", true);
            }
        },

        async changePage(page) {
            if (page < 1 || page > this.lastPage) return;
            await this.fetchProducts(page);
        },

        async deleteProduct(productId, rowElement) {
            if (!confirm("Are you sure about deleting this?")) return;
            this.loading = true;
            try {
                const response = await axios.delete(
                    `/admin/products/${productId}`,
                );
                if (response.data.status) {
                    this.showNotif(response.data.message, false);
                    rowElement.remove();
                }
            } catch (error) {
                this.showNotif(
                    error.response?.data?.message ?? "Product Deletion Failed",
                    true,
                );
            }
            this.loading = false;
        },

        async toggleActive(productId, currentStatus) {
            try {
                const response = await axios.patch(
                    `/admin/products/${productId}/toggle-active`,
                    { is_active: !currentStatus },
                );
                if (response.data.status) {
                    this.showNotif(response.data.message, false);
                    return response.data.data.is_active;
                }
            } catch (error) {
                this.showNotif(
                    error.response?.data?.message ?? "Failed To Update!",
                    true,
                );
            }
        },

        showNotif(msg, error = false) {
            this.message = msg;
            this.isError = error;
            setTimeout(() => {
                this.message = "";
                this.isError = false;
            }, 3000);
        },
    };
}

function productCreate() {
    return {
        loading: false,
        message: "",
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
                if (error.response?.status === 422) {
                    const errors = error.response.data.errors;
                    this.message = Object.values(errors).flat().join(", ");
                } else {
                    this.message =
                        error.response?.data.message ?? "Something Went Wrong!";
                }
            }
            this.loading = false;
        },
    };
}
