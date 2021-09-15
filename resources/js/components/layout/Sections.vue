<template>
    <div class="container-fluid pb-3 pb-md-5 organization-bg" v-if="organization">
        <div class="container">
            <div class="row pt-4">
                <div class="col-12">
                    <div>
                        <div class="row justify-content-center mt-md-3">
                            <div class="col-12 col-md-6 col-lg-4 p-0">
                                <div class="form-group organization-date" onselectstart="return false;">
                                    <a class="text-decoration-none cursor-pointer" :class="{'organization-arr-btn':date.before}" @click="previousDay()">&#8249;</a>
                                    <div type="text" class="border-0 organization-input text-dark text-center font-weight-bold" :data-date="date.data">
                                        <div>{{date.title}}</div>
                                    </div>
                                    <a class="text-decoration-none cursor-pointer" :class="{'organization-arr-btn':date.after}" @click="nextDay()">&#8250;</a>
                                </div>
                            </div>
                        </div>
                        <template v-if="!isWorking">
                            <div class="locked">
                                <div class="locked-icon"></div>
                                <div class="locked-info">
                                    <div class="locked-title">Заведение закрыто</div>
                                    <div class="locked-desc">Возможно в данный момент заведение закрыто или не работает.</div>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div class="row justify-content-center mt-3">
                                <div>
                                    <div class="d-flex">
                                        <button type="button" class="btn organization-btn font-weight-bold mx-2" v-for="(item,key) in sections || []" :key="key" :class="{'organization-btn-sel':(key === section)}" @click="section = key">{{item.name}}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-4"  v-for="(item,key) in sections" :key="key" :class="{'d-none':(key !== section)}">
                                <div class="col-6 col-lg-3 p-md-2 p-1" v-for="(table,tableKey) in item.organization_tables" :key="tableKey" @mousedown="selTable(key,tableKey)">
                                    <div class="card border-0 organization-shadow" data-toggle="modal" data-target="#booking_modal">
                                        <div class="card-body organization-card-main">
                                            <div class="organization-card">
                                                <div class="row align-content-center pl-3">
                                                    <div class="organization-card-title w-100 font-weight-bold">{{table.title}}</div>
                                                    <div class="lds-ellipsis" v-if="table.bookingStatus === undefined">
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                    <div class="organization-card-status organization-card-status-free" v-else-if="table.status === 'ENABLED' && (table.bookingStatus === null || table.bookingStatus.status === 'COMPLETED')">
                                                        <span v-if="table.price > 0">Депозит {{table.price}} ₸</span>
                                                        <span v-else>Свободно</span>
                                                    </div>
                                                    <div class="organization-card-status organization-card-status-reserved" v-else>Занято</div>
                                                </div>
                                                <div>
                                                    <div class="organization-card-icon"></div>
                                                    <div class="organization-card-limit text-secondary text-center">{{table.limit}} чл.</div>
                                                </div>
                                                <div class="organization-card-arr"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Booking :organization="organization" :table="table" :date="date"></Booking>
</template>
<script>
import Booking from '../modal/Booking';
export default {
    components: {
        Booking
    },
    props: ['id','organization'],
    name: "Sections",
    data() {
        return {
            isWorking:  true,
            date: {
                timeTitle: '',
                before: false,
                after: true,
                title: '',
                data: '',
                timeIndex: 0,
                time: [],
                timeList: [{time: '00:00',},{time: '01:00',},{time: '02:00',},{time: '03:00',},{time: '04:00',},{time: '05:00',},{time: '06:00',},{time: '07:00',},{time: '08:00',},{time: '09:00',},{time: '11:00',},{time: '12:00',},{time: '13:00',},{time: '14:00',},{time: '15:00',},{time: '16:00',},{time: '17:00',},{time: '18:00',},{time: '19:00',},{time: '20:00',},{time: '21:00',},{time: '22:00',},{time: '23:00',}],
                monthName: {
                    ru: ['Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Октября','Ноября','Декабря'],
                    en: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь']
                },
            },
            table: false,
            section: 0,
            sections: [],
            lang: 'ru',
        }
    },
    created() {
        this.setDateTime();
        this.getSections();
    },
    methods: {
        updateStatus: async function() {
            let self    =   this;
            return axios.get('/api/organization/status/'+this.id+'/'+this.date.data)
                .then(response => {
                    let data    =   response.data;
                    let statuses    =   [];
                    data.forEach(element => {
                        if (!statuses[element.organization_table_id]) {
                            statuses[element.organization_table_id]    =   [];
                        }
                        statuses[element.organization_table_id].push(element);
                    });
                    this.sections.forEach(element => {
                        if (statuses[element.id]) {
                            element.organization_tables =   statuses[element.id];
                        }
                    });
                    this.setTime();
                }).catch(error => {
                    setTimeout(function() {
                        self.updateStatus();
                    },1000);
                });
        },
        getSections: function() {
            if (this.id) {
                axios.get('/api/organization/section/'+this.id)
                    .then(response => {
                        this.sections   =   response.data.data;
                        this.updateStatus();
                    });
            } else {
                let self    =   this;
                setTimeout(function() {
                    self.getSections();
                },100);
            }
        },
        selTable: async function (key, tableKey) {
            await this.updateStatus();
            this.storage.modal = false;
            this.table = this.sections[key].organization_tables[tableKey];
            this.setTime();
        },
        timeConvert: function(time) {
            let converted   =   time.split(':');
            return converted[0]+'.'+converted[1];
        },
        setTime: function() {
            let date    =   this.date.data.split('-');
            date        =   new Date(date[0],(date[1]-1),date[2]);
            let weekDay =   date.getDay();
            let week;
            if (weekDay === 0) {
                week    =   this.organization.sunday;
                this.isWorking = this.organization.sunday.work === 'on';
            } else if (weekDay === 1) {
                week    =   this.organization.monday;
                this.isWorking = this.organization.monday.work === 'on';
            } else if (weekDay === 2) {
                week    =   this.organization.tuesday;
                this.isWorking = this.organization.tuesday.work === 'on';
            } else if (weekDay === 3) {
                week    =   this.organization.wednesday;
                this.isWorking = this.organization.wednesday.work === 'on';
            } else if (weekDay === 4) {
                week    =   this.organization.thursday;
                this.isWorking = this.organization.thursday.work === 'on';
            } else if (weekDay === 5) {
                week    =   this.organization.friday;
                this.isWorking = this.organization.friday.work === 'on';
            } else if (weekDay === 6) {
                week    =   this.organization.saturday;
                this.isWorking = this.organization.saturday.work === 'on';
            }

            if (week.start === week.end) {
                this.date.timeTitle =   'круглосуточно';
            } else {
                this.date.timeTitle  =   'c '+this.timeConvert(week.start)+' до '+this.timeConvert(week.end);
            }
            let today   =   new Date();
            let timeToday   =   new Date(today.getFullYear(),today.getMonth(),today.getDate());
            let item;
            let start   =   week.start.split(':');
            let end     =   week.end.split(':');
            this.date.timeIndex =   0;
            this.date.time  =   [];
            if (timeToday.getTime() === date.getTime()) {
                let arr =   [];
                if (week.start === week.end) {
                    this.date.timeList.forEach(element => {
                        item    =   element.time.split(':');
                        if (parseInt(today.getHours()) <= parseInt(item[0])) {
                            arr.push(element);
                        }
                    });
                    this.date.time  =   arr;
                } else {
                    this.date.timeList.forEach(element => {
                        item    =   element.time.split(':');
                        let status  =   (parseInt(end[0]) < parseInt(start[0]))?true:(parseInt(item[0])<parseInt(end[0]));
                        if (parseInt(item[0]) >= parseInt(start[0]) && parseInt(today.getHours()) < parseInt(item[0]) && status) {
                            arr.push(element);
                        }
                    });
                    if (parseInt(end[0]) < parseInt(start[0])) {
                        this.date.timeList.forEach(element => {
                            item    =   element.time.split(':');
                            if (parseInt(item[0]) < parseInt(end[0]) ) {
                                arr.push(element);
                            }
                        });
                    }
                }
                this.date.time  =   arr;
            } else {
                let arr =   [];
                if (week.start === week.end) {
                    arr =   this.date.timeList;
                } else {
                    this.date.timeList.forEach(element => {
                        item    =   element.time.split(':');
                        let status  =   (parseInt(end[0]) < parseInt(start[0]))?true:(parseInt(item[0])<parseInt(end[0]));
                        if (parseInt(item[0]) >= parseInt(start[0]) && status) {
                            arr.push(element);
                        }
                    });
                    if (parseInt(end[0]) < parseInt(start[0])) {
                        this.date.timeList.forEach(element => {
                            item    =   element.time.split(':');
                            if (parseInt(item[0]) < parseInt(end[0]) ) {
                                arr.push(element);
                            }
                        });
                    }
                }
                this.date.time  =   arr;
            }
        },
        setDateTime: function() {
            let date    =   new Date();
            let year    =   date.getFullYear();
            let month   =   date.getMonth();
            let day     =   date.getDate();
            this.date.title =   day+' '+this.date.monthName[this.lang][month];
            this.date.data  =   year+'-'+(month + 1)+'-'+day;
        },
        previousDay: function() {
            if (this.date.before) {
                let today   =   new Date();
                today       =   new Date(today.getFullYear(),today.getMonth(),today.getDate());
                let date    =   this.date.data.split('-');
                let current =   new Date(date[0],(date[1] - 1),date[2]);
                current.setDate(current.getDate() - 1);
                if (today.getTime() <= current.getTime()) {
                    let year    =   current.getFullYear();
                    let month   =   current.getMonth();
                    let day     =   current.getDate();
                    this.date.title =   day+' '+this.date.monthName[this.lang][month];
                    this.date.data  =   year+'-'+(month + 1)+'-'+day;
                    if (today.getTime() === current.getTime()) {
                        this.date.before    =   false;
                    }
                    this.updateStatus();
                    this.setTime();
                }
            }
        },
        nextDay: function() {
            let date    =   this.date.data.split('-');
            let current =   new Date(date[0],(date[1]-1),date[2]);
            current.setDate(current.getDate() + 1);
            let year    =   current.getFullYear();
            let month   =   current.getMonth();
            let day     =   current.getDate();
            this.date.title =   day+' '+this.date.monthName[this.lang][month];
            this.date.data  =   year+'-'+(month + 1)+'-'+day;
            this.date.before    =   true;
            this.updateStatus();
            this.setTime();
        },
    }
}
</script>

<style lang="scss">
    .locked {
        display: flex;
        max-width: 350px;
        font-size: 14px;
        margin: 50px auto 0 auto;
        padding: 10px;
        align-items: center;
        gap: 10px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 1px 1px rgba(0,0,0,.05);
        &-icon {
            width: 60px;
            height: 60px;
            background: url('/img/logo/locked.png') no-repeat center;
            background-size: contain;
        }
        &-info {

        }
        &-title {
            font-size: 14px;
            color: black;
            font-weight: bold;
        }
        &-desc {
            font-size: 11px;
            color: grey;
        }
    }
    @media only screen and (max-width: 768px) {
        .locked {
            margin-top: 40px;
            margin-bottom: 20px;
        }
    }
</style>
