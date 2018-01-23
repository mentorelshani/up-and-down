<script>
    export default {
        data() {
            return {
                accessPoints:{},
                details:{
                    version:{},
                    elevator:{},
                },
                detailsRelay:{},

                elevators:null,
                versions:{},
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

                relayName:"Relay 1",
                relayFloor:null,
                relayPulseTime:null,


            }
        },

        props: {
            entryId:null,
        },

        beforeCreate() {
        },

        created() {
            
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
                this.detailsRelay={};
                this.relayName = "Relay " + this.index;
                this.relayFloor=null;
                this.relayPulseTime=null;


                // this.detailsRelay.access_point_id=
                // console.log(this.index);

             
                console.log(this.index);

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

            nextRelay:function() {
                if(this.index < this.numberOfRelays)
                {
                    this.index++;
                }
                else
                {
                    this.index=this.numberOfRelays;
                }
                // this.relayName = "Relay " + this.index;
                // this.setRelayDetails(this.index);
            },

            previousRelay:function () {
                if(this.index > 1)
                {
                    this.index--;
                }
                else
                {
                    this.index=1;
                }

                // this.relayName = "Relay " + this.index++;
                // this.setRelayDetails(this.index);
            },

            modalAdd:function() {
                //---->this function call in other function
                this.getElevator();
                this.getVersion();
                this.details={};
                //---->this function call in other function


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
                this.getDetails(this.newAccessPointId);
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