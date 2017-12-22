<script>
    export default {
        data: function() {
            return {
             
                idBuilding:null,
                detailsBuilding:{
                },


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

                elevatorDetails:{
                    entry_id:null,
                    identifier:null,
                    type:null,
                    company:null,
                    madeIn:null,
                },

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
            console.log(this.$route.params.id);
        },

        mounted() {
            this.getBuildingDetails();
        },

        watch: {
        },

        computed: {

        },

        methods: {
            getBuildingDetails:function() {
                this.$http.get('/getBuilding/'+this.idBuilding)
                    .then(response => {
                        this.detailsBuilding=response.data;
                    })
                    .catch(e => {
                        console.log(e);
                        this.errorDetailsBuilding="This building not found";
                    });
            },

            getEntryDetails:function(entryId) {
                console.log(entryId);
            },

            
        },
    }
</script>

<template src="./templates/building_details.html">

</template>

<style>
    
</style>