function userManager() {
    return {
        users: [],
        message: "",
        isError: false,
        currentPage: 1,
        lastPage: 1,

        fetchUsers() {
            fetch(`/admin/users/data?page=${this.currentPage}`)
                .then((res) => res.json())
                .then((res) => {
                    this.users = res.data.data;
                    this.lastPage = res.data.last_page;
                })
                .catch(() => {
                    this.isError = true;
                    this.message = "Failed to fetch users";
                });
        },

        deleteUser(user) {
            if (!confirm("Are you sure you want to delete this user?")) return;

            fetch(`/admin/users/${user.id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
            })
                .then((res) => res.json())
                .then((res) => {
                    this.message = res.message;
                    this.isError = !res.status;
                    if (res.status)
                        this.users = this.users.filter((u) => u.id !== user.id);
                    setTimeout(() => (this.message = ""), 3000);
                })
                .catch(() => {
                    this.isError = true;
                    this.message = "Failed to delete user";
                    setTimeout(() => (this.message = ""), 3000);
                });
        },

        changePage(page) {
            if (page < 1 || page > this.lastPage) return;
            this.currentPage = page;
            this.fetchUsers();
        },
    };
}
