function orderManager(updateStatusUrlTemplate) {
    return {
        orders: [],
        message: "",
        isError: false,
        currentPage: 1,
        lastPage: 1,

        fetchOrders() {
            fetch(`/admin/orders/data?page=${this.currentPage}`)
                .then((res) => res.json())
                .then((res) => {
                    this.orders = res.data.data;
                    this.lastPage = res.data.last_page;
                })
                .catch(() => {
                    this.isError = true;
                    this.message = "Failed to fetch orders";
                });
        },

        updateStatus(order) {
            const url = updateStatusUrlTemplate.replace("/0/", `/${order.id}/`);
            fetch(url, {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": window.csrfToken, // pastikan di layout ada meta csrf
                },
                body: JSON.stringify({ status: order.status }),
            })
                .then((res) => {
                    if (!res.ok) throw new Error("Network response not ok");
                    return res.json();
                })
                .then((res) => {
                    this.message = res.message;
                    this.isError = !res.status;
                    setTimeout(() => (this.message = ""), 3000);
                })
                .catch((err) => {
                    console.error(err);
                    this.isError = true;
                    this.message = "Failed to update status";
                    setTimeout(() => (this.message = ""), 3000);
                });
        },

        changePage(page) {
            if (page < 1 || page > this.lastPage) return;
            this.currentPage = page;
            this.fetchOrders();
        },
    };
}
