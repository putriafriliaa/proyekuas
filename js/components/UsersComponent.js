const UsersComponent = {
  template: '#users-template',
  data() {
    return {
      users: [],
      id: null,
      username: '',
      password: '',
      full_name: '',
      role: 'Operator',
      phone: '',
      message: ''
    }
  },
  mounted() {
    this.fetchUsers();
  },
  methods:{
    fetchUsers() {
      fetch('api/users.php')
      .then(res => {
        if (!res.ok) throw new Error("Unauthorized");
        return res.json();
      })
      .then(data => {
        this.users = data;
      })
      .catch(() => {
        alert("Session habis / tidak punya akses");
      });
    },
    addUsers() {
      const isEdit = !!this.id;

      if (!this.username || (!isEdit && !this.password) || !this.full_name) {
        alert("Data belum lengkap");
        return;
      }

      const method = isEdit ? 'PUT' : 'POST';
      const url = isEdit ? `api/users.php?id=${this.id}` : 'api/users.php';

      fetch(url, {
        method: method,
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
          username: this.username,
          password: this.password,
          full_name: this.full_name,
          role: this.role,
          phone: this.phone
        })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
        this.resetForm();
        this.fetchUsers();
        } else {
          alert (data.error);
        }
      });
    },
    editUser(u) {
      this.id = u.id;
      this.username = u.username;
      this.full_name = u.full_name;
      this.role = u.role;
      this.phone = u.phone;
      this.password = '';
    },
    deleteUser(id) {
      if (!confirm("Delete user?")) return;

      fetch('api/users.php?id=' + id, {
        method: 'DELETE'
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert(data.success);
          this.fetchUsers();
        } else {
          alert(data.error);
        }
      })
      .catch(err => {
        console.error("Error:", err);
        alert("Terjadi kesalahan");
      });
    },
    resetForm() {
      this.id = null;
      this.username = '';
      this.password = '';
      this.full_name = '';
      this.role = 'Operator';
      this.phone = '';
    }
  }
};
