
Vue.use(VueMask.VueMaskPlugin);

let app = new Vue({
    el: "#app",
    data() {
        return {
            user_id: 0,
            user: false,
            id: 0,
            sections: [],
            date: new Date(),
            status: true,
            showModal: false,
            booking: {
                time: '',
                phone: '',
                name: '',
                table: false,
                status: true,
            }
        }
    },
    watch: {
        date: function() {
            this.getBookingStatuses();
        }
    },
    created() {
        this.setOrganizationId();
        this.getUser();
    },
    mounted() {
        this.getSections();
    },
    methods: {
        getUser: function() {
            axios.get('/api/user/'+this.user_id)
                .then(response => {
                    this.user   =   response.data.data;
                    window.Echo = new Echo({
                        broadcaster: 'pusher',
                        key: 'e23697fdbb3e80ef3f02',
                        cluster: 'ap2',
                        authEndpoint: '/api/user/token/'+this.user.api_token,
                    });
                    window.Echo.private('booking.notification.organization.'+this.id)
                        .listen('.booking.organization.completed', (e) => {
                            this.updateStatus(e.booking);
                            this.play(e.booking.status);
                        });
                });
        },
        came: function(item) {
            axios.post('/api/booking/update/'+item.booking.id, {
                status: 'came'
            }).then(response => {
                let list        =   JSON.parse(JSON.stringify(this.sections));
                list.forEach(section => {
                    section.organization_tables.forEach(table => {
                        if (item.id === table.id) {
                            table.booking.status    =   'came';
                        }
                    });
                });
                this.sections   =   list;
            });
        },
        complete: function(item) {
            axios.post('/api/booking/update/'+item.booking.id, {
                status: 'COMPLETED'
            }).then(response => {
                let list        =   JSON.parse(JSON.stringify(this.sections));
                list.forEach(section => {
                    section.organization_tables.forEach(table => {
                        if (item.id === table.id) {
                            table.booking  =   null;
                        }
                    });
                });
                this.sections   =   list;
            });
        },
        cancel: function(item) {
            axios.post('/api/booking/update/'+item.booking.id,{
                status: 'off'
            }).then(response => {
                let list        =   JSON.parse(JSON.stringify(this.sections));
                list.forEach(section => {
                    section.organization_tables.forEach(table => {
                        if (item.id === table.id) {
                            table.booking  =   null;
                        }
                    });
                });
                this.sections   =   list;
            });
        },
        startBooking: function(table) {
            this.showModal = true;
            this.booking.table  =   table;
        },
        newBooking: function() {
            if (this.booking.status) {
                if (this.booking.time.trim().length !== 5) {
                    return this.$refs.time.focus();
                } else if (this.booking.phone.trim().length !== 18) {
                    return this.$refs.phone.focus();
                } else if (this.booking.name.trim() === '') {
                    return this.$refs.name.focus();
                }
                this.booking.status =   false;
                axios.post('/api/user/booking/',{
                    timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                    user_id: this.user_id,
                    organization_id: this.booking.table.organization_id,
                    organization_table_id: this.booking.table.id,
                    phone: this.booking.phone.replace(/[^0-9]/g, ''),
                    name: this.booking.name,
                    date: this.date.getFullYear()+'-'+(this.date.getMonth()+1)+'-'+this.date.getDate(),
                    time: this.booking.time
                }).then(response => {
                    this.booking.status =   true;
                    this.showModal      =   false;
                    this.booking.phone  =   '';
                    this.booking.name   =   '';
                    this.updateStatus(response.data.data);
                }).catch(error => {
                    this.booking.status =   true;
                });
            }
        },
        phoneCheck: function() {
            if (this.booking.phone.trim().length === 18) {
                let phone   =   this.booking.phone.replace(/[^0-9]/g, '');
                axios.get('/api/user/phone/'+phone).then(response => {
                    let data    =   response.data.data;
                    this.booking.name   =   data.name;
                });
            }
        },
        setOrganizationId: function() {
            this.id         =   document.getElementById('organization').value;
            this.user_id    =   document.getElementById('user_id').value;
        },
        getSections: function() {
            axios.get('/api/section/organization/'+this.id)
                .then(response => {
                    this.sections   =   JSON.parse(JSON.stringify(response.data.data));
                    this.status     =   false;
                    this.getBookingStatuses();
                });
        },
        getBookingStatuses: function() {
            let ids     =   [];
            this.sections.forEach(section => {
                section.organization_tables.forEach(table => {
                    ids.push(table.id);
                });
            });
            let date    =   this.date.getFullYear()+'-'+(this.date.getMonth()+1)+'-'+this.date.getDate();
            axios.post('/api/booking/ids/'+date,{
                ids: ids
            })
                .then(response => {
                    let bookings    =   response.data;
                    let list        =   JSON.parse(JSON.stringify(this.sections));
                    list.forEach(function(section, sectionIndex, sectionArray) {
                        section.organization_tables.forEach(function(table, tableIndex, tableArray) {
                            let item =   null;
                            for (const booking of bookings) {
                                if (booking && booking.organization_table_list_id === table.id) {
                                    item    =   booking;
                                }
                            }
                            tableArray[tableIndex].booking  =   item;
                        });
                    });
                    this.sections   =   list;
                });
        },
        updateStatus: function(booking) {
            let list        =   JSON.parse(JSON.stringify(this.sections));
            let currentDate =   new Date(this.date.getFullYear(),this.date.getMonth(),this.date.getDate());
            let split       =   booking.date.split('-');
            let bookingDate =   new Date(split[0],(split[1]-1),split[2]);
            if (currentDate.getTime() === bookingDate.getTime()) {
                list.forEach(section => {
                    section.organization_tables.forEach(table => {
                        if (booking.organization_table_list_id === table.id) {
                            if (booking.status === 'on' || booking.status === 'came' || booking.status === 'CHECKING') {
                                table.booking  =   booking;
                                if (this.booking.table && this.booking.table.id === table.id) {
                                    this.showModal  =   false;
                                }
                            } else {
                                table.booking  =   null;
                            }
                        }
                    });
                });
                this.sections   =   list;
            }
        },
        play: function(status) {
            if (status === 'on' || status === 'CHECKING') {
                document.getElementById('notification').play();
            }
        }
    }
});
