Vue.use(VueMask.VueMaskPlugin);

function getMimeType(file, fallback = null) {
    const byteArray = (new Uint8Array(file)).subarray(0, 4);
    let header = '';
    for (let i = 0; i < byteArray.length; i++) {
        header += byteArray[i].toString(16);
    }
    switch (header) {
        case "89504e47":
            return "image/png";
        case "47494638":
            return "image/gif";
        case "ffd8ffe0":
        case "ffd8ffe1":
        case "ffd8ffe2":
        case "ffd8ffe3":
        case "ffd8ffe8":
            return "image/jpeg";
        default:
            return fallback;
    }
}

let app = new Vue({
    el: "#app",
    data() {
        return {
            showModal: false,
            modalIndex: null,
            img: {
                src: null,
                type: null
            },
            image: null,
            wallpaper: {
                src: null,
                type: null
            },
            wall: null,
            id: 0,
            organization: '',
            categories: [],
            cities: [],
            tags: [],
            tagStatus: false,
            status: true,
            success: false,
        };
    },
    created() {
        this.setOrganizationId();
        this.getCountries();
        this.getCategories();
        this.getOrganization();
        this.getTags();
    },
    methods: {
        optionSwitch: function(tag,id) {
            let tags    =   JSON.parse(JSON.stringify(this.tags));
            let status;
            if (tags[tag].tags_option[id].status === 'on') {
                tags[tag].tags_option[id].status   =   status   =   'off';
            } else {
                tags[tag].tags_option[id].status   =   status   =   'on';
            }
            this.tags   =   tags;
            axios.post('/api/tagsOptionOrganization/update',{
                organization_id: this.id,
                tags_option_id: tags[tag].tags_option[id].id,
                status: status
            });
        },
        workDay: function(key) {
            if (key === 0) {
                if (this.organization.monday.work === 'on') {
                    this.organization.monday.work   =   'off';
                } else {
                    this.organization.monday.work   =   'on';
                }
            } else if (key === 1) {
                if (this.organization.tuesday.work === 'on') {
                    this.organization.tuesday.work   =   'off';
                } else {
                    this.organization.tuesday.work   =   'on';
                }
            } else if (key === 2) {
                if (this.organization.wednesday.work === 'on') {
                    this.organization.wednesday.work   =   'off';
                } else {
                    this.organization.wednesday.work   =   'on';
                }
            } else if (key === 3) {
                if (this.organization.thursday.work === 'on') {
                    this.organization.thursday.work   =   'off';
                } else {
                    this.organization.thursday.work   =   'on';
                }
            } else if (key === 4) {
                if (this.organization.friday.work === 'on') {
                    this.organization.friday.work   =   'off';
                } else {
                    this.organization.friday.work   =   'on';
                }
            } else if (key === 5) {
                if (this.organization.saturday.work === 'on') {
                    this.organization.saturday.work   =   'off';
                } else {
                    this.organization.saturday.work   =   'on';
                }
            } else if (key === 6) {
                if (this.organization.sunday.work === 'on') {
                    this.organization.sunday.work   =   'off';
                } else {
                    this.organization.sunday.work   =   'on';
                }
            }
        },
        uploadImage: function() {
            if (this.image) {
                this.organization.image =   this.image;
                this.showModal  =   false;
                axios.post('/api/organization/update/'+this.id,{
                    image: this.image,
                });
            }
        },
        uploadWallpaper: function() {
            if (this.wall) {
                this.organization.wallpaper =   this.wall;
                this.showModal  =   false;
                axios.post('/api/organization/update/'+this.id,{
                    wallpaper: this.wall,
                });
            }
        },
        changeWallpaper: function({coordinates, canvas}) {
            const ctx = canvas.getContext('2d');
            let imageData = ctx.getImageData(coordinates.left, coordinates.top, coordinates.width, coordinates.height);
            this.wall  =   canvas.toDataURL();
        },
        loadWallpaper: function(event) {
            const { files } = event.target;
            if (files && files[0]) {
                if (this.wallpaper.src) {
                    URL.revokeObjectURL(this.wallpaper.src);
                }
                const blob = URL.createObjectURL(files[0]);
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.wallpaper = {
                        src: blob,
                        type: getMimeType(e.target.result, files[0].type),
                    };
                };
                reader.readAsArrayBuffer(files[0]);
            }
        },
        setWallpaper: function() {
            this.modalIndex =   1;
            this.showModal  =   true;
        },
        setPhoto: function() {
            this.modalIndex =   0;
            this.showModal  =   true;
        },
        loadImage(event) {
            const { files } = event.target;
            if (files && files[0]) {
                if (this.img.src) {
                    URL.revokeObjectURL(this.img.src);
                }
                const blob = URL.createObjectURL(files[0]);
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.img = {
                        src: blob,
                        type: getMimeType(e.target.result, files[0].type),
                    };
                };
                reader.readAsArrayBuffer(files[0]);
            }
        },
        change({coordinates, canvas}) {
            const ctx = canvas.getContext('2d');
            let imageData = ctx.getImageData(coordinates.left, coordinates.top, coordinates.width, coordinates.height);
            this.image  =   canvas.toDataURL();
        },
        categoryChange: function() {
            this.categories.forEach(category => {
                if (category.id === this.organization.category) {
                    this.organization.category_id   =   category;
                }
            });
        },
        saveOrganization: function() {
            if (this.organization.title.trim() === '') {
                return this.$refs.organization_title.focus();
            } else if (this.organization.price.trim() === '') {
                return this.$refs.price.focus();
            } else if (this.timeCheck(this.organization.monday.start)) {
                return this.$refs.organization_monday_start.focus();
            } else if (this.timeCheck(this.organization.monday.end)) {
                return this.$refs.organization_monday_end.focus();
            } else if (this.timeCheck(this.organization.tuesday.start)) {
                return this.$refs.organization_tuesday_start.focus();
            } else if (this.timeCheck(this.organization.tuesday.end)) {
                return this.$refs.organization_tuesday_end.focus();
            } else if (this.timeCheck(this.organization.wednesday.start)) {
                return this.$refs.organization_wednesday_start.focus();
            } else if (this.timeCheck(this.organization.wednesday.end)) {
                return this.$refs.organization_wednesday_end.focus();
            } else if (this.timeCheck(this.organization.thursday.start)) {
                return this.$refs.organization_thursday_start.focus();
            } else if (this.timeCheck(this.organization.thursday.end)) {
                return this.$refs.organization_thursday_end.focus();
            } else if (this.timeCheck(this.organization.friday.start)) {
                return this.$refs.organization_friday_start.focus();
            } else if (this.timeCheck(this.organization.friday.end)) {
                return this.$refs.organization_friday_end.focus();
            } else if (this.timeCheck(this.organization.saturday.start)) {
                return this.$refs.organization_saturday_start.focus();
            } else if (this.timeCheck(this.organization.saturday.end)) {
                return this.$refs.organization_saturday_end.focus();
            } else if (this.timeCheck(this.organization.sunday.start)) {
                return this.$refs.organization_sunday_start.focus();
            } else if (this.timeCheck(this.organization.sunday.end)) {
                return this.$refs.organization_sunday_end.focus();
            }
            if (this.status) {
                this.status = false;
                this.success    =   false;
                axios.post('/api/organization/update/'+this.id,{
                    title: this.organization.title.trim(),
                    description: this.organization.description,
                    description_kz: this.organization.description_kz,
                    description_en: this.organization.description_en,
                    _2gis: this.organization._2gis,
                    price: this.organization.price,

                    start_monday: this.organization.monday.start,
                    end_monday: this.organization.monday.end,
                    work_monday: this.organization.monday.work,

                    start_tuesday: this.organization.tuesday.start,
                    end_tuesday: this.organization.tuesday.end,
                    work_tuesday: this.organization.tuesday.work,

                    start_wednesday: this.organization.wednesday.start,
                    end_wednesday: this.organization.wednesday.end,
                    work_wednesday: this.organization.wednesday.work,

                    start_thursday: this.organization.thursday.start,
                    end_thursday: this.organization.thursday.end,
                    work_thursday: this.organization.thursday.work,

                    start_friday: this.organization.friday.start,
                    end_friday: this.organization.friday.end,
                    work_friday: this.organization.friday.work,

                    start_sunday: this.organization.sunday.start,
                    end_sunday: this.organization.sunday.end,
                    work_sunday: this.organization.sunday.work,

                    start_saturday: this.organization.saturday.start,
                    end_saturday: this.organization.saturday.end,
                    work_saturday: this.organization.saturday.work,

                    address: this.organization.address,
                    phone: this.organization.phone,
                    email: this.organization.email,
                    website: this.organization.website,
                    instagram: this.organization.instagram,
                    youtube: this.organization.youtube,
                    facebook: this.organization.facebook,
                    vk: this.organization.vk,
                    city_id: this.organization.city_id,
                    category_id: this.organization.category
                }).then(response => {
                    this.success    =   true;
                    this.status =   true;
                }).catch(element => {
                    this.status =   true;
                });
            }
        },
        timeCheck: function(time) {
            let split   =   time.split(':');
            if (split.length === 2 && split[0].trim() !== '' && split[1].trim() !== '' && split[0].length === 2 && split[1].length === 2) {
                if (parseInt(split[0], 10) < 24 && parseInt(split[1], 10) <= 59) {
                    return false;
                }
            }
            return true;
        },
        getOrganization: function() {
            axios.get('/api/organization/'+this.id).then(response => {
                this.organization   =   response.data.data;
            });
        },
        getTags: function() {
            axios.get('/api/tags/list').then(response => {
                this.tags   =   response.data;
                this.getOtherTags();
            });
        },
        getOtherTags: function() {
            axios.get('/api/tagsOption/other').then(response => {
                this.tags.push({
                    tags_option: response.data
                });
                this.getTagsOrganization();
            });
        },
        getTagsOrganization: function() {
            axios.get('/api/tagsOptionOrganization/getByOrganizationId/'+this.id).then(response => {
                let data    =   response.data;
                let tags    =   JSON.parse(JSON.stringify(this.tags));
                data.forEach(option => {
                    tags.forEach(tag => {
                        tag.tags_option.forEach(tag_option => {
                            if (tag_option.id === option.tags_option_id) {
                                tag_option.status   =   option.status;
                            }
                        });
                    });
                });
                this.tags   =   tags;
                this.tagStatus  =   true;
            });
        },
        setOrganizationId: function() {
            let organization    =   document.getElementById('organization');
            this.id =   organization.value;
        },
        getCategories: function() {
            axios.get('/api/category/list')
                .then(response => {
                    this.categories       =   response.data.data;
                });
        },
        getCountries: function() {
            axios.get('/api/countries')
                .then(response => {
                    let data    =   response.data.data;
                    data.forEach(country => {
                        country.city_id.forEach(city => {
                            this.cities.push(city);
                        });
                    });
                });
        }
    },
});
