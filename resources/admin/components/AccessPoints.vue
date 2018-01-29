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
                index:1,

                newAccessPointId:null,
                errorAccessPoint:{},
                modal:{
                    title:null,
                    btnEdit:false,
                    btnAdd:false,
                    btnConfigRelay:false,
                },

                relays:[],
                   
                relayName:"Relay 1",
                relayFloor:null,
                relayPulseTime:null,

                relayAreConfig:[],
                relayConfigStatus:null,
            }
        },

        props: {
            entryId:null,
        },

        beforeCreate() {
        },

        created() {
            this.relayAreConfig[0]=null;
        },

        mounted() {
        },

        computed: {

        },

        watch: {
            entryId:function() {
                this.getAll();
                this.getElevator();
                this.getVersion();
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
                        console.log("Access Point u shtua me sukses = !false");
                        this.modal.btnConfigRelay=true;
                        this.modal.btnAdd=false;
                        this.newAccessPointId=response.data.id;

                        this.relays=[];
                        for(var i=1 ; i<=this.numberOfRelays ; i++)
                        {
                            this.relays[i]={
                                index:i,
                            }
                        }
                        this.getAll();
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

            setRelayDetails: function(param){
                this.index = param;
                this.relayName = "Relay " + this.index;
                this.relayFloor=null;
                this.relayPulseTime=null;

                if(this.relayAreConfig[param]==param) {
                    this.getRelayDetails(this.relays[param].id);
                }
                else {
                    console.log('ka je ka shkon ej!');
                }
            },

            chooseVersion:function() {
                this.details.version_id=this.details.version.id;
                this.numberOfRelays=this.details.version.number_of_relays;
            },

            chooseElevator:function() {
                this.details.elevator_id=this.details.elevator.id;

            },
            // getRelayNumber:function(relayName) {
            //     console.log(relayName);
            // },

            addRelay:function() {
                this.detailsRelay={};
                this.detailsRelay={
                    access_point_id:this.newAccessPointId,
                    relay:this.index,
                    floor:this.relayFloor,
                    pulse_time:this.relayPulseTime
                };

                this.$http.post(`/addRelay`,this.detailsRelay)
                    .then(response => {
                        this.relays[this.index]=response.data;
                        this.relayAreConfig[this.index]=this.index;
                        this.setRelayDetails(this.index);
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            getRelayDetails:function(relayId) {
                this.$http.get('/getRelay/'+relayId)
                    .then(response => {
                        console.log(response.data);
                        this.relayName=response.data.relay;
                        this.relayFloor=response.data.floor;
                        this.relayPulseTime=response.data.pulse_time;

                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            getRelaysAccessPoint:function(idAccessPoint) {
                this.modalConfigRelay();

                this.relays=[];
                this.relays[0]=null;
                this.relayAreConfig=[];

                this.getDetails(idAccessPoint);
                this.$http.get('/getRelays/'+idAccessPoint)
                    .then(response => {
                        console.log(response.data);

                        for (var i = 1; i <= response.data.length; i++) {                   
                            this.relays[i]=response.data[i-1];
                            this.relayAreConfig[i]=i;

                            console.log(this.relayAreConfig);
                            console.log(this.relays);
                        }
                    })
                    .catch(e => {
                        console.log(e);
                    });
                this.setRelayDetails(10);
            },

            nextRelay:function() {
                if(this.index < this.numberOfRelays) {
                    this.index++;
                }
                else {
                    this.index=this.numberOfRelays;
                }

                this.setRelayDetails(this.index);
                console.log(this.setRelayDetails(this.index));
                this.relayName = "Relay " + this.index;
            },

            previousRelay:function () {
                if(this.index > 1) {
                    this.index--;
                }
                else {
                    this.index=1;
                }

                this.setRelayDetails(this.index);
                console.log(this.setRelayDetails(this.index));
                this.relayName = "Relay " + this.index;
            },

            modalAdd:function() {
                this.clearDetails();

                this.modal.title="Add new access points!";
                this.modal.btnAdd=true;
                this.modal.btnEdit=false;
                this.modal.btnConfigRelay=false;
            },

            modalEdit:function(IMEI) {
                this.modal.title="Edit access points: "+ IMEI;
                this.modal.btnAdd=false;
                this.modal.btnEdit=true;
                this.modal.btnConfigRelay=false;
            },

            modalConfigRelay:function() {
                this.modal.title="Edit relays configuration!";
                
                this.modal.btnAdd=false;
                this.modal.btnEdit=false;
                this.modal.btnConfigRelay=false;
            },

            clearDetails:function() {
                this.details.IMEI=null;
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
        },
    }

</script>

<template src="./templates/accessPoints.html">
</template>