<template>
    <loading v-if="Loading"></loading>
    <div class="container-fluid py-3 py-md-4 item-bg" v-else-if="organizations.length > 0 && storage.favorite.length > 0">
        <div class="container">
            <div class="row">
                <div class="result">
                    <div class="result-body">
                        <div class="result-body-main result-body-main-single">
                            <Card :organization="organization" v-for="(organization,key) in organizations" :key="key"></Card>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <not-found v-else :params="NotFound" ></not-found>
</template>

<script>
import Loading from '../layout/Loading';
import NotFound from '../layout/Not-found';
import Filter from '../layout/Filter';
import Card from '../layout/Card';
export default {
    props: ['category'],
    name: "Organization",
    components: {
        Loading,
        NotFound,
        Filter,
        Card
    },
    data() {
        return  {
            NotFound: {
                img: '/img/logo/favorite-red.svg',
                title: 'Список пуст',
                description: 'Здесь будет отображаться список добавленных вами заведении.'
            },
            Loading: true,
            organizations: [],
        }
    },
    created() {
        this.getOrganizations();
    },
    methods: {
        getOrganizations: function() {
            if (this.storage.favorite.length > 0) {
                axios.post('/api/organization/ids',{
                    ids: this.storage.favorite
                })
                    .then(response => {
                        let data    =   response.data.data;
                        for (let i = 0; i < data.length; i++) {
                            data[i].timeTitle   =   this.getTime(data[i]);
                            this.organizations.push(data[i]);
                        }
                        if (data.length === 0) {
                            this.storage.favorite   =   [];
                            this.organizations   =   [];
                        }
                        this.Loading    =   false;
                    }).catch(error => {
                        this.storage.favorite   =   [];
                        this.organizations   =   [];
                        this.Loading    =   false;
                    });
            } else {
                this.storage.favorite   =   [];
                this.organizations  =   [];
                this.Loading    =   false;
            }
        },
        getTime: function(organization) {
            let today   =   new Date();
            today       =   new Date(today.getFullYear(),today.getMonth(),today.getDate());
            let weekDay =   today.getDay();
            let week;
            if (weekDay === 0) {
                week    =   organization.sunday;
            } else if (weekDay === 1) {
                week    =   organization.monday;
            } else if (weekDay === 2) {
                week    =   organization.tuesday;
            } else if (weekDay === 3) {
                week    =   organization.wednesday;
            } else if (weekDay === 4) {
                week    =   organization.thursday;
            } else if (weekDay === 5) {
                week    =   organization.friday;
            } else if (weekDay === 6) {
                week    =   organization.saturday;
            }
            if (week.start === week.end) {
                return 'круглосуточно';
            }
            return 'c '+this.timeConvert(week.start)+' до '+this.timeConvert(week.end);
        },
        timeConvert: function(time) {
            let converted   =   time.split(':');
            return converted[0]+':'+converted[1];
        },
    }
}
</script>

<style lang="scss">
@import '../../../css/layout/organization.scss';
</style>
