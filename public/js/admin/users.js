function userManager() {
    return {
        users: [],
        currentPage: 1,
        lastPage: 1,

        async fetchUsers(page = 1) {
            try {
                const res = await axios.get(`/admin/users/data?page=${page}`);
                this.users = res.data.data.data;
                this.currentPage = res.data.data.current_page;
                this.lastPage = res.data.data.last_page;
            } catch (e) {
                console.error("Failed to fetch users");
            }
        },

        async changePage(page) {
            if (page < 1 || page > this.lastPage) return;
            await this.fetchUsers(page);
        }
    }
}