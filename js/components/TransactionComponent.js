const TransactionsComponent = {
  template: '#transactions-template',
  data() {
    return {
      customer_name: '',
      customer_phone: '',
      weight: '',
      price: '',
      transactions: []
    }
  },
  mounted() {
    this.loadData();
  },
  methods: {
    loadData() {
      fetch('api/transactions.php')
        .then(res => res.json())
        .then(data => this.transactions = data);
    },
    saveTransaction() {
      fetch('api/transactions.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: new URLSearchParams({
          customer_name: this.customer_name,
          customer_phone: this.customer_phone,
          weight: this.weight,
          price: this.price
        })
      })
      .then(res => res.json())
      .then(() => {
        this.loadData();
        this.customer_name = '';
        this.customer_phone = '';
        this.weight = '';
        this.price = '';
      });
    }
  }
};
