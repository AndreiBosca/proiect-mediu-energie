document.addEventListener('DOMContentLoaded', function() {
  const ctx = document.getElementById('consumptionChart');
  if (ctx) {
    fetch('api_readings.php')
      .then(response => response.json())
      .then(data => {
        new Chart(ctx, {
          type: 'line',
          data: {
            labels: data.labels,
            datasets: [{
              label: 'Consum (kWh)',
              data: data.data,
              borderColor: 'blue',
              backgroundColor: 'rgba(0, 0, 255, 0.1)',
              fill: true
            }]
          }
        });
      });
  }
});