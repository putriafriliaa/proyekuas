const PickupsComponent = {
  template: '#pickups-template',
  data() {
    return { transactions: [] }
  },
  mounted() {
    this.load();
  },
  methods: {
    load() {
      fetch('api/pickups.php')
        .then(res => res.json())
        .then(data => this.transactions = data);
    },
    pickup(id) {
      fetch('api/pickups.php', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body: new URLSearchParams({ transaction_id:id })
      })
      .then(()=>this.load());
    }
  }
};
