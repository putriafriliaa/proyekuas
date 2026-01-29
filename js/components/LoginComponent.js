const LoginComponent = {
  template: '#login-template',
  data() {
    return {
      username: '',
      password: '',
      error: ''
    }
  },
  methods: {
    login() {
      fetch('api/login.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
          username: this.username,
          password: this.password
        })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          this.$emit('login-success', data.user);
        } else {
          this.error = data.message;
        }
      });
    }
  }
};
