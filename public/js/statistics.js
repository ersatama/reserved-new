Vue.use(VueMask.VueMaskPlugin);

let app = new Vue({
    el: "#app",
    data() {
        return {
            id: 0,
            showModal: false,
            colors: [
                {bg: 'rgba(87,162,131,.2)',ln: 'rgba(87,162,131,.7)'},
                {bg: 'rgba(255,128,8,.2)',ln: 'rgba(255,128,8,.7)'},
                {bg: 'rgba(30, 144, 255,.2)',ln: 'rgba(30, 144, 255,.7)'},
                {bg: 'rgba(255, 69, 0,.2)',ln: 'rgba(255, 69, 0,.7)'},
                {bg: 'rgba(238, 130, 238,.2)',ln: 'rgba(238, 130, 238,.7)'},
                {bg: 'rgba(139, 69, 19,.2)',ln: 'rgba(139, 69, 19,.7)'},
                {bg: 'rgba(25, 25, 112,.2)',ln: 'rgba(25, 25, 112,.7)'},
                {bg: 'rgba(255, 160, 122,.2)',ln: 'rgba(255, 160, 122,.7)'},
                {bg: 'rgba(255, 215, 0,.2)',ln: 'rgba(255, 215, 0,.7)'},
                {bg: 'rgba(128, 128, 128,.2)',ln: 'rgba(128, 128, 128,.7)'},
            ],
            selectedDate: {
                start: new Date(),
                end: new Date(),
            },
            web: {
                labels: [],
                list: [],
            },
            booking: {
                labels: [],
                list: []
            },
            review: {
                labels: [1,2,3,4,5],
                list: []
            },
            barChart: '<canvas id="barChart"></canvas>',
            pieChart: '<canvas id="pieChart"></canvas>',
            lineChart: '<canvas id="lineChart"></canvas>',
        }
    },
    created() {
        this.setOrganizationId();
        this.setTime();
    },
    mounted() {
        this.setWeb();
        this.getWeb();
        this.setBooking();
        this.getBooking();
        this.setReview();
        this.getReview();
    },
    methods: {
        readyFilter: function() {
            this.showModal  =   false;
            this.getWeb();
            this.getBooking();
        },
        getStartDate: function() {
            return this.selectedDate.start.getFullYear()+'-'+(this.selectedDate.start.getMonth()+1)+'-'+this.selectedDate.start.getDate();
        },
        getEndDate: function() {
            return this.selectedDate.end.getFullYear()+'-'+(this.selectedDate.end.getMonth()+1)+'-'+this.selectedDate.end.getDate();
        },
        getReview: function() {
            axios.get('/api/review/group/'+this.id)
                .then(response => {
                    let data    =   response.data;
                    let arr     =   [];
                    this.review.labels.forEach(label => {
                        let total   =   0;
                        data.forEach(item => {
                            if (label === item.rating) {
                                total   =   item.total;
                            }
                        });
                        arr.push(total);
                    });
                    this.pieChart   =   '<canvas id="pieChart"></canvas>';
                    new Chart(document.getElementById('pieChart'), {
                        type: 'pie',
                        data: {
                            labels: this.review.labels,
                            datasets: [{
                                data: arr,
                                backgroundColor: [
                                    'rgba(87,162,131,1,)',
                                    'rgba(255,128,8,1)',
                                    'rgba(30, 144, 255,1)',
                                    'rgba(255, 69, 0,1)',
                                    'rgba(238, 130, 238,1)'
                                ],
                                hoverBackgroundColor: [
                                    'rgba(87,162,131,1)',
                                    'rgba(255,128,8,1)',
                                    'rgba(30, 144, 255,1)',
                                    'rgba(255, 69, 0,1)',
                                    'rgba(238, 130, 238,1)'
                                ]
                            }]
                        },
                        options: {
                            responsive: true
                        }
                    });
                });
        },
        setReview: function() {
            new Chart(document.getElementById('pieChart'), {
                type: 'pie',
                data: {
                    labels: this.review.labels,
                    datasets: this.review.list
                },
                options: {
                    responsive: true
                }
            });
        },
        setBooking: function() {
            new Chart(document.getElementById('barChart'), {
                type: 'bar',
                data: {
                    labels: this.booking.labels,
                    datasets: this.booking.list
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        },
        getBooking: function() {
            axios.get('/api/booking/dateBetween/'+this.getStartDate()+'/'+this.getEndDate()+'/'+this.id)
                .then(response => {
                    let data    =   response.data;
                    let labels  =   [];
                    let list    =   [];
                    let bg      =   [];
                    let ln      =   [];
                    data.forEach(item => {
                        labels.push(item.date);
                        list.push(item.total);
                        bg.push(this.colors[0].bg);
                        ln.push(this.colors[0].ln);
                    });
                    this.barChart  =   '<canvas id="barChart"></canvas>';
                    new Chart(document.getElementById('barChart'), {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Статистика бронирвовании',
                                    data: list,
                                    backgroundColor: bg,
                                    borderColor: ln,
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                });
        },
        setWeb: function() {
            new Chart(document.getElementById('lineChart'), {
                type: 'line',
                data: {
                    labels: this.web.labels,
                    datasets: this.web.list
                },
                options: {
                    responsive: true
                }
            });
        },
        onlyUnique: function(value, index, self) {
            return self.indexOf(value) === index;
        },
        getWeb: function() {
            axios.get('/api/webTraffic/dateBetween/'+this.getStartDate()+'/'+this.getEndDate()+'/'+this.id)
                .then(response => {
                    let data    =   response.data;
                    let labels  =   [];
                    let list    =   [];
                    data.forEach(item => {
                        labels.push(item.date);
                    });
                    labels  =   labels.filter(this.onlyUnique);
                    let i = 0;
                    data.forEach(item => {
                        if (!(item.website in list)) {
                            list[item.website]  =   {
                                label: item.website,
                                data: [],
                                backgroundColor: this.colors[i].bg,
                                borderColor: this.colors[i].ln,
                                borderWidth: 2
                            };
                        }
                        labels.forEach(label => {
                            if (item.date === label) {
                                list[item.website].data[label]  =   item.total;
                            } else if (list[item.website].data[label] === undefined) {
                                list[item.website].data[label]  =   0;
                            }
                        });
                        i++;
                        if (i > 9) {
                            i = 0;
                        }
                    });
                    let arr =   [];
                    for (let i in list) {
                        arr.push(list[i]);
                    }
                    arr.forEach(item => {
                        list    =   [];
                        for (let i in item.data) {
                            list.push(item.data[i]);
                        }
                        item.data   =   list;
                    })
                    this.web.labels =   labels.filter(this.onlyUnique);
                    this.web.list   =   arr;
                    this.lineChart  =   '<canvas id="lineChart"></canvas>';
                    new Chart(document.getElementById('lineChart'), {
                        type: 'line',
                        data: {
                            labels: this.web.labels,
                            datasets: this.web.list
                        },
                        options: {
                            responsive: true
                        }
                    });
                });
        },
        setTime: function() {
            let start   =   new Date();
            let end     =   new Date();
            start.setDate(end.getDate() - 7);
            this.selectedDate.start =   start;
            this.selectedDate.end   =   end;
        },
        setFilter: function() {

        },
        setOrganizationId: function() {
            let organization    =   document.getElementById('organization');
            this.id =   organization.value;
        },
    }
});
