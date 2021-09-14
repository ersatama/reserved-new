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
    name: "searchOrganization",
    components: {
        Loading,
        NotFound,
        Filter,
        Card
    },
    data() {
        return  {
            NotFound: {
                img: '/img/logo/reserved-logo.png',
                title: 'Список пуст',
                description: 'Заведении не найдено'
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
            if (this.$route.query.tag && this.$route.query.tag.trim() !== '') {
                axios.get('/api/organization/tag/'+this.$route.query.tag.trim())
                    .then(response => {
                        let data    =   response.data;
                        console.log(data);
                        this.Loading    =   false;
                    }).catch(error => {
                        this.organizations   =   [];
                        this.Loading    =   false;
                    });
            } else {
                this.organizations   =   [];
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

</style>
