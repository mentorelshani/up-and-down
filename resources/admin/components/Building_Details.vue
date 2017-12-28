<script>
    export default {
        data: function() {
            return {
             
                idBuilding:null,
                idEntry:null,
                detailsBuilding:null,
                elevatorDetails:{},

                activeEntry:null,

                firstId:null,
                detailsEntry: {
                    id: null,
                    building: null,
                    entry: null,
                    nrFloor: null,
                    nrApartaments: null,
                },

                relays: [],

                relayName:null,
                relayfloor:null,
                relayPulsTime:null,



                versions:null,
                versionAccessPoint:null,
                numberOfRelays:null,

                relayDetails:null,

                addButton:true,
                editButton:false,
                clearButton:true,
                relayName:null,
                index:1,

                active_relay:false,
                active_relationRelays:false,
                active_SaveAccessPoint:false,

                btnConfigRelays:true,
                active:false,

            }
        },

        beforeCreate() {

        },

        created() {
            this.idBuilding=this.$route.params.id;

        },

        mounted() {
            this.idEntry=14;
            this.getBuildingDetails(this.idBuilding);
            console.log(this.firstId);
        },

        watch: {
            idEntry:function() {
                
                
            }
        },

        computed: {

        },

        methods: {
            getBuildingDetails:function(param) {
                console.log('fsdf');
                this.$http.get('/getBuilding/'+param)
                    .then(response => {
                        this.detailsBuilding=response.data;
                        if(this.idEntry != response.data.entries[0].id)
                        {
                            this.idEntry = response.data.entries[0].id;
                        }
                        
                    })
                    .catch(e => {
                        console.log(e);
                        // this.errorDetailsBuilding="This building not found";
                    });
            },

            getEntryDetails:function(entryId) {
                this.idEntry=entryId;
                console.log(entryId);
                this.activeEntry=true;
            },
            
        },
    }
</script>

<template src="./templates/building_details.html">

</template>

<style>
    
</style>