<script>
    export default {
        data() {
            return {
                accessPoints:{},
                details:{
                    elevator:{},
                    version:{},
                },

                versions:{},
                numberOfRelays:16,
                index:1,

                modal:{
                    title:null,
                    btnEdit:false,
                    btnAdd:false,
                },
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
            this.getVersion();
        },

        computed: {
           
        },

        watch: {
            entryId:function() {
                this.getAll();
                this.clearDetails();
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
                        console.log(response.data);
                    })
                    .catch(e => {
                        console.log(e);
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

            setRelayDetails: function(param){

                this.relayDetails={
                    access_point_id:this.accessPoints.id,
                    relay:this.relayName,
                    floor:this.relayfloor,
                    pulse_time:this.relayPulsTime,
                }
                console.log(this.index);

                this.index = param;
                this.relayName = "Relay " + this.index;
                this.relayfloor=null;
                this.relayPulsTime=null;
                console.log(this.index);

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
            
            chooseVersion:function() {
                // this.relays = [];
                this.details.versionId=this.details.version.id;
                this.numberOfRelays=this.details.version.number_of_relays;
                this.relayName=null;

                this.versionAccessPoint=this.details.version.name;
            },

            getRelayNumber:function(relayName) {
                console.log(relayName);
            },

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
                this.clearDetails();

                this.modal.title="Add new access points!";
                this.modal.btnAdd=true;
                this.modal.btnEdit=false;
            },

            modalEdit:function(IMEI) {
                this.modal.title="Edit access points: "+ IMEI;
                this.modal.btnAdd=false;
                this.modal.btnEdit=true;
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

