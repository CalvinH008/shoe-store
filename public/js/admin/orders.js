function orderManager() {
    return {
        orders: [],
        currentPage: 1,
        lastPage: 1,

        async fetchOrders(page = 1) {
            try {
                const res = await axios.get(`/admin/orders/data?page=${page}`);
                this.orders = res.data.data.data;
                this.currentPage = res.data.data.current_page;
                this.lastPage = res.data.data.last_page;
            } catch (e) {
                console.error("Failed to fetch orders");
            }
        },

        async changePage(page) {
            if (page < 1 || page > this.lastPage) return;
            await this.fetchOrders(page);
        },
    };
}
