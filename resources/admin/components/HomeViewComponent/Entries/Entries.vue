<script>
    import alert from '../../../services/sweetAlert.js'
    
    export default {
        data: function () {
            return {
                entries:{},
                details:{
                    active:true,
                },
                search: {},
                location: {},
                error_details: {},
                error_getAll: {},
                center:{ 
                    lat:42.59118019362772,
                    lng:20.81822595624999
                },

                showDetails:false,
                showEntriesBody:true,
            }
        },

        props: {
        },

        beforeCreate() {
        },

        created() { 
            this.$store.commit('setShowFilterBy', true );
        },

        mounted() {  
            if(this.showDetails == false ) {
                this.showDetails=false;
                this.showEntriesBody=true;
            }        
        },

        computed: {
        },

        watch: {
        },

        methods:{
            getAll:function() {
                this.$http.get(``)
                .then(response => {
                    console.log(response.data);
                    this.entries=response.data;
                })
                .catch(e => {
                    this.error_getAll=e.body;
                })
            },

            getDetails:function(idEntry) {
                this.$http.post(``,idEntry)
                .then(response => {
                    console.log(response.data);
                    this.details=response.data;
                })
                .catch(e => {
                    this.error_details=e.body;
                });
            },

            add:function() {
                this.$http.post(``,this.details)
                .then(respons => {
                    console.log(response.data);
                    swal({ title:"Success!", text:null, type:"success" });
                })
                .catch(e => {
                    this.error_details=e.body;
                })
            },

            update:function(idEntry) {
                let vm=this;

                vm.idEntry=this.details.entry_id;
                alert.modify(function() {
                    vm.$http.post('/',vm.details)
                    .then(response => {
                        vm.getAll();
                        vm.error_details={};
                    })
                    .catch(e => {
                        swal({ title:"Error!", text:'This row has not been updated!', type:"error" });
                        vm.error_details=e.body;

                    });
                })
            },

            delete:function(idEntry) {
                let vm=this;

                alert.delete(function () {
                    vm.$http.delete(`/`+idEntry)
                        .then(response => {
                            vm.getAll();
                        })
                        .catch(e => {
                            alert.information("Error",'This row has not been removed!',"error");
                        });
                });
            },

            modalAdd:function() {
            },

            modalEdit:function() {
            },

            modalAddNew:function() {
                let vm=this;

                vm.details.active=false;
                vm.details.active=true;
                this.details.active=true;
            },

            clicked:function(e) {
                this.location = {
                    latLng: e.latLng,
                }
                
                this.details.lat=this.location.latLng.lat();
                this.details.lng=this.location.latLng.lng();
            },

            detailsSubMenu:function(status) {
                let vm=this;
                if(status == true){
                    vm.showDetails=true;
                    vm.showEntriesBody=true;
                }
                else if(status == false) {
                    vm.showDetails=false;
                    vm.showEntriesBody=true;
                    vm.$store.commit('setShowFilterBy', true );
                }
            },

            subMenuBody:function() {
                this.showEntriesBody=false;
                this.$store.commit('setShowFilterBy', false );
            },

            changeStatusEntries:function(entry) {
                let vm=this;
                vm.details=entry;             

                alert.modify(function() {
                    vm.details.active=!vm.details.active;  
                    vm.$http.post('/updateAccessPoint',vm.details)
                        .then(response => {
                            // vm.error={};
                            console.log(response);
                            vm.getAll();//
                        })
                        .catch(e => {
                            swal({ title:"Error!", text:'This row has not been updated!', type:"error" });
                            vm.details.active=!vm.details.active;
                        });
                    });
            },

            chooseCompany:function() {

            },

            chooseAddress:function() {

            },

            chooseCity:function() {

            },
        }
    }
</script>

<template src="../../templates/entries.html">
</template>