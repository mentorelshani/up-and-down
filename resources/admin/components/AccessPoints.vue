<script>
    
    import alert from '../components/service/sweetAlert.js'
    // const alert =new sweetAlert();

    export default {
        // components: { Multiselect },
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
                    limit:100,
                    page:1,
                },
                errorMonitor:{},

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

                monitorsData:{},
                checkinsData:{},

                buildingFloor:[
                   'Hyrja',
                    'Garazha',
                    'Kati -2',
                    'Kati -1',
                    'Kati 0',
                    'Kati 1',
                    'Kati 2',
                    'Kati 3',
                    'Kati 4',
                    'Kati 5',
                    'Kati 6',
                    'Kati 7',
                    'Kati 8',
                    'Kati 9',
                    'Kati 10',
                    'Kati 11',
                    'Vip 1',
                    'Vip 2',
                    'None',
                ],
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
            this.getDate();
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
            },  

            objVersion:function() {
                return this.versions.map(g => ({label:g.name, value: g}));
            }, 
        },

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

            getDetails:function(accessPoint_id) {
         
                this.monitor.access_point_id=accessPoint_id;
                this.monitorCards(accessPoint_id);
                this.errorAccessPoint={};

                this.$http.get('/getAccessPoint/'+accessPoint_id)
                    .then(response => {
                        this.details=response.data;
                        this.numberOfRelays=response.data.version.number_of_relays;
                        this.errorAccessPoint={};

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
                        this.errorAccessPoint={};
                        swal({ title:"Success!", text:null, type:"success" });

                    })
                    .catch(e => {
                        swal({ title:"Error!", text:'This row has not been added!', type:"error" });
                        this.errorAccessPoint=e.body;
                    });
            },

            edit:function() {
                let vm=this;

                alert.modify(function() {
                    vm.$http.post('/updateAccessPoint',vm.details)
                    .then(response => {
                        // swal({ title:"Success!", text:null, type:"success" });
                        vm.getAll();
                        vm.errorAccessPoint={};
                    })
                    .catch(e => {
                        swal({ title:"Error!", text:'This row has not been updated!', type:"error" });
                        vm.errorAccessPoint=e.body;

                    });
                }) 
            },

            destroy:function(accessPoint_id) {
                let vm=this;

                alert.delete(function () {
                    vm.$http.delete(`/deleteAccessPoint/`+accessPoint_id)
                        .then(response => {
                            vm.getAll();
                        })
                        .catch(e => {
                            alert.information("Error",'This row has not been removed!',"error");
                        });
                });
            },

            getVersion: function() {
                this.$http.get(`/getVersions`)
                    .then(response => {
                        this.versions=response.data;
                        // this.details.version=this.versions[0];
                        // this.chooseVersion();
                        // for (var key in this.versions) {
                        //     console.log(this.versions[key].selectedRoles);
                        // }

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

            getRelaysAccessPoint:function(accessPoint_id) {
                this.modalAddRelays();
                this.AccessPointId=accessPoint_id;

                this.relays=[];
                var vm = this;

                this.getDetails(accessPoint_id);
                this.$http.get('/getRelays/'+accessPoint_id)
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

            modalConfigRelay:function(accessPoint_id) {
                // this.AccessPointId=accessPoint_id;
                this.btnSavedRelay=true;

                this.modal.title="Edit relays configuration!";
                this.modal.btnAdd=false;
                this.modal.btnEdit=false;
                this.modal.btnConfigRelay=false;
            },

            modalAddRelays:function(accessPoint_id) {
                // this.AccessPointId=accessPoint_id;

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

            getDate:function() {

                this.today = new Date();
                this.year = this.today.getFullYear();
                this.month =this.today.getMonth()+1;
                this.day =this.today.getDate();
                this.dayFrom=this.today.getDate()-1;

                if(this.day < 10) {
                     this.day='0'+this.day;
                }
                
                if(this.month < 10 ) {
                    this.month='0'+this.month;
                }

                if(this.dayForm < 10) {       
                    this.dayFrom='0'+this.dayFrom;
                }

                this.monitor.to=this.year+'-'+this.month+'-'+this.day;
                this.monitor.from=this.year+'-'+this.month+'-'+this.dayFrom;

                console.log(this.today);
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
                this.$http.post('/getMonitors/'+80,this.monitor)
                    .then(response => {
                        console.log(response.data);
                        this.monitorsData=response.data.data;
                        this.errorMonitor={};
                        // this.pagination.current_page=response.data.current_page;
                        // this.pagination.from=response.data.from;
                        // this.pagination.last_page=response.data.last_page;
                        // this.pagination.per_page=response.data.per_page;
                        // this.pagination.to=response.data.to;
                        // this.pagination.total=response.data.total
                        // this.getAll();
                    })
                    .catch(e => {
                        console.log(e.body);
                        this.errorMonitor=e.body;
                        this.monitorsData=null;

                    });
            },
        },
    }

</script>

<template src="./templates/accessPoints.html">
</template>