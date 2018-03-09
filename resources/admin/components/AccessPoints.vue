<script>
    export default {
        data() {
            return {
                accessPoints:{},
                details:{
                    version:{},
                    elevator:{},
                },
                detailsRelay:{
                    id:null,
                    access_point_id:null,
                    floor:null,
                    relay:null,
                    pulse_time:null,
                },

                elevators:null,
                versions:null,
                numberOfRelays:16,

                newAccessPointId:null,
                AccessPointId:null,
                errorAccessPoint:{},
                modal:{
                    title:null,
                    btnEdit:false,
                    btnAdd:false,
                    btnConfigRelay:false,
                },

                relays:{},
                relayDetails:{},
                firstRelay:{},

                relayConfigStatus:null,
                btnSavedRelay:true,

                monitor:{
                    from:null,
                    to:null,
                    access_point_id:null,
                    orderBy:'cards.id',
                    relation:['cards.site_code'],
                    value:null,
                    asc:true,
                    totelRecord:null,
                    limit:20,
                    page:1,
                },

                checkins:{
                    from:null,
                    to:null,
                    access_point_id:null,
                    orderBy:'cards.id',
                    relation:['cards.site_code'],
                    value:null,
                    asc:true,
                    totelRecord:null,
                    limit:20,
                    page:1,
                },

                pagination:{},

                monitorsData:null,
                checkinsData:null,
            }
        },

        props: {
            entryId:null,
        },

        filters: {
        },

        beforeCreate() {
        },

        created() {
            
        },

        mounted() {
        },

        computed: {
            monitorFrom:function() {
                return this.monitor.from;
            },

            monitorTo:function() {
                return this.monitor.to;
            },

            monitorSearch:function() {
                return this.monitor.value;
            },        },

        watch: {
            keySearch: function() {
                this.inputSearch=null;
                this.paginate__page=1;
                // this.getAll();
            },

            show__items: function() {
                this.paginate__page=2;
                // this.getAll();
            },

            entryId:function() {
                this.getAll();
                this.getElevator();
                this.getVersion();

                this.$store.watch(
                    (state)=>{
                        return this.$store.getters.getShowItem
                    },
                    (val)=>{
                        this.show__items=this.$store.getters.getShowItem;
                        this.getAll();
                    });

                this.$store.watch(
                    (state)=>{
                        return this.$store.getters.getPaginatePage
                    },
                    (val)=>{
                        this.paginate__page=this.$store.getters.getPaginatePage;
                        this.getAll();
                    });
            },

            monitornFrom:function() {
                // this.monitorCards(this.monitor.access_point_id);
                console.log('fdsf');
            },

            monitornTo:function() {
                // this.monitorCards(this.monitor.access_point_id);
                console.log('12345');

            },

            monitorSearch:function() {
                console.log('fasdas');
            }
        },

        methods:{
            getAll:function() {
                this.$http.get('/getAccessPoints/'+this.entryId)
                    .then(response => {
                        this.accessPoints=response.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            getDetails:function(idAccessPoint) {
                this.$http.get('/getAccessPoint/'+idAccessPoint)
                    .then(response => {
                        this.details=response.data;
                        this.numberOfRelays=response.data.version.number_of_relays;
                        console.log(this.numberOfRelays);
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            add:function() {
                this.$http.post('/addAccessPoint',this.details)
                    .then(response => {
                        console.log(response.data);
                        console.log("Access Point u shtua me sukses = !false");
                        this.modal.btnConfigRelay=true;
                        this.modal.btnAdd=false;
                        this.newAccessPointId=response.data.id;

                        this.relays=response.data.relays;
                        this.relayDetails=response.data.relays[0];

                        this.getAll();
                        this.setRelayDetails(response.data.relays[0].id);

                    })
                    .catch(e => {
                        console.log("Access Point u shtua me sukses = false");
                        this.errorAccessPoint=e.body;
                    });
            },

            edit:function() {
                this.$http.post('/updateAccessPoint',this.details)
                    .then(response => {
                        console.log(response.data);
                        this.getAll();
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            destroy:function(idAccessPoint) {
                this.$http.delete(`/deleteAccessPoint/`+idAccessPoint)
                    .then(response => {
                        console.log('U fshi me sukses');
                        this.getAll();
                    })
                    .catch(e => {
                        console.log(e.respone);
                    });
            },

            getVersion: function() {
                this.$http.get(`/getVersions`)
                    .then(response => {
                        this.versions=response.data;
                        this.details.version=this.versions[0];
                        this.chooseVersion();

                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            getElevator: function() {
                this.$http.get('/getElevators/'+this.entryId)
                    .then(response => {
                        this.elevators=response.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            setRelayDetails: function(relay_id){
                this.relayDetails={};

                this.$http.get('/getRelay/'+relay_id)
                    .then(response => {
                        this.relayDetails=response.data;
                        console.log(response.data);
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            chooseVersion:function() {
                this.details.version_id=this.details.version.id;
                this.numberOfRelays=this.details.version.number_of_relays;
            },

            chooseElevator:function() {

                this.details.elevator_id=this.details.elevator.id;
            },

            editRelay:function() {
                this.$http.post(`/updateRelay`,this.relayDetails)
                    .then(response => {
                        console.log(response.data);
                        this.relays[parseInt(response.data.relay)-1]=response.data;
                        this.setRelayDetails(this.relayDetails.id);

                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            getRelaysAccessPoint:function(idAccessPoint) {
                this.modalAddRelays();
                this.AccessPointId=idAccessPoint;

                this.relays=[];
                var vm = this;

                this.getDetails(idAccessPoint);
                this.$http.get('/getRelays/'+idAccessPoint)
                    .then(response => {
                        console.log(response.data);
                        this.relays = response.data;
                        this.relayDetails=response.data[0];
                        this.firstRelay=response.data[0];
                        this.setRelayDetails(response.data[0].id);

                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            nextRelay:function() {
                if(this.relayDetails.relay < this.numberOfRelays) {
                    this.relayDetails.id++;
                }
                else if(this.relayDetails.id==this.firstRelay.id + (this.numberOfRelays-1)) {
                    this.relayDetails.id=this.firstRelay.id + (this.numberOfRelays-1);
                }
                
                this.setRelayDetails(this.relayDetails.id);
            },

            previousRelay:function () {
                if(this.relayDetails.relay > 1) {
                    this.relayDetails.id--;
                }
                else {
                    this.relayDetails.id=this.firstRelay.id;
                }

                this.setRelayDetails(this.relayDetails.id);
            },

            modalAdd:function() {
                this.clearDetails();
                this.getElevator();
                this.getVersion();

                this.modal.title="Add new access points!";
                this.modal.btnAdd=true;
                this.modal.btnEdit=false;
                this.modal.btnConfigRelay=false;
            },

            modalEdit:function() {
                this.modal.title="Edit access points!";
                this.modal.btnAdd=false;
                this.modal.btnEdit=true;
                this.modal.btnConfigRelay=false;
            },

            modalMonitors:function(accessPoint_id) {

                this.monitor.access_point_id=accessPoint_id;
            },

            modalConfigRelay:function(idAccessPoint) {
                // this.AccessPointId=idAccessPoint;
                this.btnSavedRelay=true;

                this.modal.title="Edit relays configuration!";
                this.modal.btnAdd=false;
                this.modal.btnEdit=false;
                this.modal.btnConfigRelay=false;
            },

            modalAddRelays:function(idAccessPoint) {
                // this.AccessPointId=idAccessPoint;

                this.modal.title="Relays configuration!";
                this.modal.btnAdd=false;
                this.modal.btnEdit=false;
                this.modal.btnConfigRelay=false;
            },

            clearDetails:function() {
                this.details.imei=null;
                this.details.created_at=null;
                this.details.elevator={};
                this.details.elevator_id=null;
                this.details.id=null;
                this.details.notes=null;
                this.details.phone_number=null;
                this.details.updated_at=null;
                this.details.version={};
                this.details.version_id=null;
            },

            checkinsAccessPoint() {
                this.$http.post('/getCheckIns/'+accessPoint_id,this.checkins)
                    .then(response => {
                        console.log(response.data);
                        this.checkinsData=response.data.data;

                        this.pagination.current_page=response.data.current_page;
                        this.pagination.from=response.data.from;
                        this.pagination.last_page=response.data.last_page;
                        this.pagination.per_page=response.data.per_page;
                        this.pagination.to=response.data.to;
                        this.pagination.total=response.data.total
                        // this.getAll();
                    })
                    .catch(e => {
                        console.log(e);
                    }); 
            },

            monitorCards:function(accessPoint_id) {
                this.$http.post('/getMonitors/'+accessPoint_id,this.monitor)
                    .then(response => {
                        console.log(response.data);
                        this.monitorsData=response.data.data;

                        // this.pagination.current_page=response.data.current_page;
                        // this.pagination.from=response.data.from;
                        // this.pagination.last_page=response.data.last_page;
                        // this.pagination.per_page=response.data.per_page;
                        // this.pagination.to=response.data.to;
                        // this.pagination.total=response.data.total
                        // this.getAll();
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
        },
    }

</script>

<template src="./templates/accessPoints.html">
</template>