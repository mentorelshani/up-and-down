<script>
    export default {
        data() {
            return {
                accessPoints:{},
                details:{},

                versions:{},
                numberOfRelays:16,
                index:1,
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
            if(this.entryId != null) {
                this.getAll();
            }
            else {
                console.log('hej nuk osht mire');
            }
        },

        computed: {
           
        },

        watch: {
            entryId:function() {
                this.getAll();
                console.log('u ndryshua Id e entrit');
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
                console.log('a');

                this.$http.get(`/getVersions`)
                .then(response => {
                    this.versions=response.data;
                    this.details.version=this.versions[0];
                    this.chooseVersion();

                console.log('a1');

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
                console.log(this.details.version.name);
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
        },
    }

</script>

<template src="./templates/accessPoints.html">
</template>

