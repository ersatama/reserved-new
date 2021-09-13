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
            modalIndex: 0,
            id: 0,
            news: [],
            addNews: {
                image: '',
                img: {
                    src: null,
                    type: null
                },
                imageAdd: false,
                title: '',
                description: '',
                images: [],
                status: true,
            },
            changeNews: {}
        }
    },
    created() {
        this.setOrganizationId();
        this.getNews();
    },
    methods: {
        saveEdit: function() {
            if (this.changeNews.title.trim() === '') {
                return this.$refs.edit_title.focus();
            } else if (this.changeNews.description.trim() === '') {
                return this.$refs.edit_description.focus();
            }
            axios.post('/api/news/update/'+this.changeNews.id, {
                title: this.changeNews.title,
                description: this.changeNews.description
            });
            this.showModal  =   false;
        },
        editNews: function(key) {
            this.changeNews =   this.news[key];
            this.modalIndex =   1;
            this.showModal  =   true;
        },
        deleteNews: function(key) {
            this.news.splice(key,1);
            axios.post('/api/news/update/'+this.id, {
                status: 'off'
            });
        },
        getNews: function() {
            axios.get('/api/news/getByOrganizationId/'+this.id)
                .then(response => {
                    this.news   =   response.data.data;
                });
        },
        readyAdd: function() {
            if (this.addNews.status) {
                if (this.addNews.title.trim() === '') {
                    return this.$refs.add_title.focus();
                } else if (this.addNews.description.trim() === '') {
                    return this.$refs.add_description.focus();
                }
                this.addNews.status =   false;
                axios.post('/api/news/create',{
                    organization_id: this.id,
                    title: this.addNews.title.trim(),
                    description: this.addNews.description.trim().replace(/(\n\n?)\n+/g, '$1'),
                    images: this.addNews.images
                }).then(response => {
                    this.news.unshift(response.data.data);
                    this.showModal  =   false;
                    this.addNews    =   {
                        image: '',
                        img: {
                            src: null,
                            type: null
                        },
                        imageAdd: false,
                        title: '',
                        description: '',
                        images: [],
                        status: true,
                    };
                });
            }
        },
        removeAddNewsImage: function(key) {
            this.addNews.images.splice(key,1);
        },
        readyImage: function() {
            this.addNews.imageAdd   =   false;
            this.addNews.images.push(this.addNews.image);
        },
        loadImage: function(event) {
            const { files } = event.target;
            if (files && files[0]) {
                if (this.addNews.img.src) {
                    URL.revokeObjectURL(this.addNews.img.src);
                }
                const blob = URL.createObjectURL(files[0]);
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.addNews.img.src    =   blob;
                    this.addNews.img.type   =   getMimeType(e.target.result, files[0].type);
                    this.addNews.imageAdd = true
                };
                reader.readAsArrayBuffer(files[0]);
            }
        },
        changeAdd: function({coordinates, canvas}) {
            const ctx = canvas.getContext('2d');
            ctx.getImageData(coordinates.left, coordinates.top, coordinates.width, coordinates.height);
            this.addNews.image  =   canvas.toDataURL();
        },
        add: function() {
            this.modalIndex =   0;
            this.showModal  =   true;
        },
        setOrganizationId: function() {
            let organization    =   document.getElementById('organization');
            this.id =   organization.value;
        },
    }
});
