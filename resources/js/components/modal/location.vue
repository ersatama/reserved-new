<template>
    <div class="modal fade" id="location" tabindex="-1" role="dialog" aria-labelledby="location" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content auth-modal">
                <div class="modal-body" onselectstart="return false">
                    <div class="form-group d-flex justify-content-end">
                        <button class="auth-btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="form-group">
                        <h3 class="auth-title text-center">Выберите местоположение</h3>
                    </div>
                    <div class="form-group my-4">
                        <div class="location-body" v-if="countries.length > 0">
                            <div class="location-country">
                                <div class="location-country-item" v-for="(country,key) in countries" :class="{'location-item-sel':(countryId === key)}" :key="key" @click="countryId = key">{{country.title}}</div>
                            </div>
                            <div class="location-city">
                                <div class="location-city-item" v-for="(city,key) in countries[countryId].city_id" :key="key" :class="{'location-item-sel':(city.id === storage.city.id)}" @click="citySel(city)" data-dismiss="modal" aria-label="Close">{{city.title}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "location",
    props: ['countries'],
    data() {
        return {
            countryId: 0,
        }
    },
    created() {
        this.countrySel();
    },
    methods: {
        countrySel: function() {
              if (this.storage.city) {
                  let index =   0;
                  this.countries.forEach(item => {
                      if (item.id === this.storage.city.country_id) {
                          this.countryId    =   index;
                      }
                      index++;
                  });
              }
        },
        citySel: function(city) {
            if (this.storage.city.id !== city.id) {
                this.storage.city   =   city;
                window.location.reload();
            }
        }
    }
}
</script>

<style scoped>

</style>
