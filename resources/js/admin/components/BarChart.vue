<script>
  import { Bar } from 'vue-chartjs'

  export default {
    extends: Bar,
    data() {
      return {  
      }
    },
    mounted() {           
          let OrderDate = new Array();
          let Total = new Array();
          let BorderColor = new Array();
          let BackgroundColor = new Array();
          var config = {
              method: "post",
              url: this.$store.state.hostBase +'/api/user/dashboard/sale',
              headers: {
                Authorization: `Bearer ${this.$store.state.token}`,
                "Content-Type": "application/x-www-form-urlencoded",
              },
              data: {},
            };
            this.axios(config).then((response) => {
              let data = response.data; 
              if(data.data) {
                 data.data.forEach(element => {
                 OrderDate.push(element.od_date);
                 Total.push(element.total_cost);
                 
                 });
                 this.renderChart({
                 labels: OrderDate,
                 datasets: [{
                    label: 'Bitcoin',
                    borderWidth: 1,
                    backgroundColor: [
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)',
                      'rgba(75, 192, 192, 0.2)',
                      'rgba(153, 102, 255, 0.2)',
                      'rgba(255, 159, 64, 0.2)',
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)',
                      'rgba(75, 192, 192, 0.2)',
                      'rgba(153, 102, 255, 0.2)',
                      'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                      'rgba(255,99,132,1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)',
                      'rgba(75, 192, 192, 1)',
                      'rgba(153, 102, 255, 1)',
                      'rgba(255, 159, 64, 1)',
                      'rgba(255,99,132,1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)',
                      'rgba(75, 192, 192, 1)',
                      'rgba(153, 102, 255, 1)',
                      'rgba(255, 159, 64, 1)'
                    ],
                    pointBorderColor: '#2554FF',
                    data: Total
              }]
           },
           {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                },
                gridLines: {
                  display: true
                }
              }],
              xAxes: [{
                gridLines: {
                  display: false
                }
              }]
            },
            legend: {
              display: true
            },
            responsive: true,
            maintainAspectRatio: false
          }
           )
         }
         else {
            console.log('No data');
         }
        });            
     }


  }
</script>