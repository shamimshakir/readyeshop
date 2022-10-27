<script>
  import { Pie } from 'vue-chartjs';
  export default {
    extends: Pie,    
    mounted() {           
          let Status = new Array();
          let Total = new Array();
          let BorderColor = new Array();
          let BackgroundColor = new Array();
          var config = {
              method: "post",
              url: this.$store.state.hostBase +'/api/user/dashboard/orderstatus',
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
                 Status.push(element.ord_status);
                 Total.push(element.total);
                 
                 });
                 this.renderChart({
                 labels: Status,
                 datasets: [{
                    borderWidth: 1,
                    label: 'Bitcoin',
                    borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255,99,200,1)',
                    'rgba(60, 162, 235, 1)',
                    'rgba(255, 100, 86, 1)',
                    'rgba(100, 192, 192, 1)'                  
                    ],
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(54, 162, 235, 0.9)',
                    'rgba(255, 206, 86, 0.9)',
                    'rgba(75, 192, 192, 0.9)',
                    'rgba(255, 99, 200, 0.9)',
                    'rgba(60, 162, 235, 0.9)',
                    'rgba(255, 100, 86, 0.9)',
                    'rgba(100, 192, 192, 0.9)'               
                    ],
                    data: Total
              }]
           },
           {
                legend: {
                  display: true,
                   position: 'left',
                },
                responsive: true,
                maintainAspectRatio: true
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