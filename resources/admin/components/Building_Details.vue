<script>
    export default {
        data: function() {
            return {
                show__address_block:null,
                show__accessPoint_block:null,
                show__accessPoint_addEdit_block:null,

                detailsBuilding:{
                },

                //Config entry main data
                show__section_config_entry:true,

                detailsEntry: {
                    id: null,
                    building: null,
                    entry: '',
                    city_id: '',
                    street: '',
                    nrFloor: '',
                    nrApartaments: '',
                },

                accessPoints: { 
                    id:null,
                    IMEI:null,
                    elevatorTel:null,
                    version:null,
                    versionId:null,
                    note:null,
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
        },

        mounted() {
            
        },

        watch: {
        },

        computed: {

        },

        methods: {
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