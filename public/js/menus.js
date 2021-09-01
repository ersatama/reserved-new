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
            photos: [],
            id: 0,
            showModal: false,
            modalIndex: 0,
            index: 0,
            img: {
                src: null,
                type: null
            },
            image: null,
            imageIndex: null,
        }
    },
    created() {
        this.setOrganizationId();
        this.getPhotos();
    },
    methods: {
        deleteImage: function() {
            let id  =   this.photos[this.imageIndex].id;
            this.photos.splice(this.imageIndex,1);
            this.showModal  =   false;
            axios.post('/api/menu/update/'+id, {
                status: 'off'
            });
        },
        imageView: function(key) {
            this.imageIndex =   key;
            this.modalIndex =   1;
            this.showModal  =   true;
        },
        change({coordinates, canvas}) {
            const ctx = canvas.getContext('2d');
            let imageData = ctx.getImageData(coordinates.left, coordinates.top, coordinates.width, coordinates.height);
            /*let cnv =   document.createElement('canvas');
            cnv.getContext('2d').putImageData(imageData,coordinates.left, coordinates.top);*/
            this.image  =   canvas.toDataURL();
        },
        newPhoto: function() {
            this.modalIndex =   0;
            this.img        =   {
                src: null,
                type: null
            };
            this.image      =   null;
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
        uploadImage() {
            if (this.image) {
                axios.post('/api/menu/create',{
                    organization_id: this.id,
                    image: this.image,
                    status: 'on',
                })
                    .then(response => {
                        this.photos.push(response.data.data);
                        this.showModal  =   false;
                    })
                    .catch(error => {
                        this.showModal  =   false;
                    });
            }
        },
        getPhotos: function() {
            axios.get('/api/menu/list/'+this.id)
                .then(response => {
                    this.photos =   response.data.data;
                });
        },
        setOrganizationId: function() {
            let organization    =   document.getElementById('organization');
            this.id =   organization.value;
        },
    }
});
