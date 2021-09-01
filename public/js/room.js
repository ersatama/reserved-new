Vue.use(VueMask.VueMaskPlugin);
let app = new Vue({
    el: "#app",
    data() {
        return {
            modalTable: 0,
            modalSection: 0,
            modalIndex: 0,
            showModal: false,
            id: 0,
            sections: [],
            newSections: [],
            newTables: [],
            newSectionsStatus: true,
            newTableStatus: true,
            sectionTemplate: {
                name: '',
                status: 'ENABLED',
            },
            tableTemplate: {
                title: '',
                limit: 1,
                price: 0,
                status: 'ENABLED',
            }
        }
    },
    created() {
        this.setOrganizationId();
        this.getSections();
    },
    methods: {
        saveEditTable: function() {
            if (this.sections[this.modalSection].organization_tables[this.modalTable].title.trim() === '') {
                return this.$refs.editTable.focus();
            }
            this.showModal = false;
            axios.post('/api/table/update/'+this.sections[this.modalSection].organization_tables[this.modalTable].id,{
                title: this.sections[this.modalSection].organization_tables[this.modalTable].title,
                limit: this.sections[this.modalSection].organization_tables[this.modalTable].limit,
                price: this.sections[this.modalSection].organization_tables[this.modalTable].price,
                status: this.sections[this.modalSection].organization_tables[this.modalTable].status,
            });
            /*
            if (this.sections[key].name.trim() === '') {
                return this.$refs.editSection.focus();
            }
            this.showModal = false;
            axios.post('/api/section/update/'+this.sections[key].id,{
                status: this.sections[key].status,
                name: this.sections[key].name
            });
             */
        },
        editTable: function(index,key,tableKey) {
            this.modalIndex =   index;
            this.modalSection   =   key;
            this.modalTable =   tableKey;
            this.showModal = true;
        },
        statusTable: function(status,key,tableKey) {
            this.sections[key].organization_tables[tableKey].status    =   status;
            axios.post('/api/table/update/'+this.sections[key].organization_tables[tableKey].id,{
                status: status
            });
        },
        saveTables: function() {
            if (this.newTableStatus) {
                let index   =   0;
                let focus   =   [];
                this.newTables.forEach(table => {
                    if (table.title.trim() === '') {
                        focus.push(index);
                    }
                    index++;
                });
                if (focus.length > 0) {
                    focus.forEach(item => {
                        return this.$refs.newTable[item].focus();
                    });
                } else {
                    this.newTableStatus =   false;
                    axios.post('/api/table/array',{
                        organization_id: this.id,
                        organization_table_id: this.sections[this.modalSection].id,
                        tables: this.newTables
                    })
                        .then(response => {
                            this.sections[this.modalSection].organization_tables    =   response.data.data;
                            this.showModal  =   false;
                            this.newTables  =   [];
                            this.newTableStatus  =   true;
                        }).catch(error => {
                            this.newTableStatus  =   true;
                        });
                }
            }
        },
        removeTable: function(key) {
            this.newTables.splice(key,1);
        },
        addTable: function() {
            this.newTables.push(JSON.parse(JSON.stringify(this.tableTemplate)));
        },
        newTable: function(index,key) {
            this.modalIndex =   index;
            this.modalSection   =   key;
            this.newTables  =   [];
            this.newTables.push(JSON.parse(JSON.stringify(this.tableTemplate)));
            this.showModal = true;
        },
        saveRooms: function() {
            if (this.newSectionsStatus) {
                let index   =   0;
                let focus   =   [];
                this.newSections.forEach(section => {
                    if (section.name.trim() === '') {
                        focus.push(index);
                    }
                    index++;
                });
                if (focus.length > 0) {
                    focus.forEach(item => {
                        return this.$refs.newSection[item].focus();
                    });
                } else {
                    this.newSectionsStatus  =   false;
                    axios.post('/api/section/create',{
                        organization_id: this.id,
                        sections: this.newSections
                    })
                        .then(response => {
                            this.sections   =   response.data.data;
                            this.showModal  =   false;
                            this.newSections    =   [];
                            this.newSectionsStatus  =   true;
                        }).catch(error => {
                            this.newSectionsStatus  =   true;
                        });
                }
            }
        },
        editRoom: function(index,key) {
            this.modalIndex =   index;
            this.modalSection   =   key;
            this.showModal = true;
        },
        saveEditRooms: function(key) {
            if (this.sections[key].name.trim() === '') {
                return this.$refs.editSection.focus();
            }
            this.showModal = false;
            axios.post('/api/section/update/'+this.sections[key].id,{
                status: this.sections[key].status,
                name: this.sections[key].name
            });
        },
        statusRoom: function(status,key) {
            this.sections[key].status = status;
            axios.post('/api/section/update/'+this.sections[key].id,{
                status: status
            });
        },
        removeRoom: function(key) {
            this.newSections.splice(key,1);
        },
        addRoom: function() {
            this.newSections.push(JSON.parse(JSON.stringify(this.sectionTemplate)));
        },
        newRooms: function(index) {
            this.modalIndex =   index;
            this.newSections    =   [];
            this.newSections.push(JSON.parse(JSON.stringify(this.sectionTemplate)));
            this.showModal = true;
        },
        getSections: function() {
            axios.get('/api/section/organization/'+this.id)
                .then(response => {
                    this.sections   =   response.data.data;
                });
        },
        setOrganizationId: function() {
            let organization    =   document.getElementById('organization');
            this.id =   organization.value;
        },
    }
});
