const ProfileComponent = {
  template: '#profile-template',
  props: ['user'],
  data() {
    return {
      oldPassword: '',
      newPassword: '',
      successMessage: '',
      errorMessage: ''
    }
  },
  methods: {
    updatePassword() {
      this.successMessage = '';
      this.errorMessage = '';

      fetch('api/update-profile.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
          old_password: this.oldPassword,
          new_password: this.newPassword
        })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          this.successMessage = data.message;
          this.oldPassword = '';
          this.newPassword = '';
        } else {
          this.errorMessage = data.message;
        }
      });
    }
  }
};
