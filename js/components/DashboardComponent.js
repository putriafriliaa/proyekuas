const DashboardComponent = {
  template: '#dashboard-template',
  props: ['user'],
  computed: {
    greeting() {
      const hour = new Date().getHours();
      if (hour < 12) return 'Selamat pagi';
      if (hour < 18) return 'Selamat siang';
      return 'Selamat malam';
    }
  }
};
