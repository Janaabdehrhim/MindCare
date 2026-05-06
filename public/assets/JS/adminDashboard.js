new Chart(document.querySelector('.chart'), {
    type:'bar',
    data:{
        labels:[
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
        ],
        datasets:[{
            label:'Sessions',
            data:[20,42,35,28,52,45,32],
            // backgroundColor:'#5d768be2',
            backgroundColor:'#005da5b0',
            borderRadius:5,
            categoryPercentage: .95,
            barPercentage: 1      
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        animation:{
            duration:3000,
            // delay: 1000
        },
        hoverBackgroundColor:"#0069BA",
        plugins:{
            legend:{
                display:false
            }
        },
        scales:{
            y:{
                display:false,
            },
            x:{
                grid:{
                    display:false
                }
            }
        }
    },
});