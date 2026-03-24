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
                    this.showNotif("Failed to fetch users", true);
                });
        },

        async toggleUser(userId) {
            try {
                const res = await fetch(
                    `/admin/users/${userId}/toggle-active`,
                    {
                        method: "PATCH",
                        headers: {
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                            Accept: "application/json",
                        },
                    },
                );

                const data = await res.json();

                this.showNotif(data.message, !data.status);

                if (data.status) {
                    // 🔥 langsung update UI tanpa reload
                    const user = this.users.find((u) => u.id === userId);
                    if (user) {
                        user.is_active = !user.is_active;
                    }
                }
            } catch (error) {
                this.showNotif("Failed to update user", true);
            }
        },

        changePage(page) {
            if (page < 1 || page > this.lastPage) return;
            this.currentPage = page;
            this.fetchUsers();
        },

        showNotif(msg, error = false) {
            this.message = msg;
            this.isError = error;

            setTimeout(() => {
                this.message = "";
            }, 3000);
        },
    };
}
