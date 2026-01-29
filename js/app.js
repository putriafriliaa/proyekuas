const { createApp } = Vue;

createApp({
  data() {
    return {
      isLogin: false,
      user: {},
      activePage: 'dashboard',
      pageTitle: 'Mini Laundry'
    }
  },
  computed: {
    displayTitle() {
      const titles = {
        'dashboard': 'Dashboard Utama',
        'transactions': 'Transaksi Laundry',
        'pickups': 'Pengambilan Laundry',
        'users': 'Manajemen User',
        'profile': 'Profil Pengguna'
      };
      return titles[this.activePage] || 'Mini Laundry';
    }
  },
  mounted() {
    fetch('api/check-session.php')
      .then(res => res.json())
      .then(data => {
        if (data.login) {
          this.isLogin = true;
          this.user = data.user;
        }
      });
  }, 
  methods: {
    logout() {
      fetch('api/logout.php', {
        method: 'POST'
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          this.isLogin = false;
          this.user = null;
        } else {
          this.error = data.message;
        }
      });
    }, onLoginSuccess(user_data) {
        this.isLogin = true;
        this.user = user_data;
  }
  }
})
.component('login-component', LoginComponent)
.component('dashboard-component', DashboardComponent)
.component('profile-component', ProfileComponent)
.component('users-component', UsersComponent)
.component('transactions-component', TransactionsComponent)
.component('pickups-component', PickupsComponent)
.mount('#app');
