<script>
    export default {
 		data: function() {
            return {
                show__address_block:null,
                show__accessPoint_block:null,
                show__accessPoint_addEdit_block:null,

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
            // this.show__address_block=this.$store.getters.getEntrySection.address;
            this.show__address_block=false;

            this.show__accessPoint_block=this.$store.getters.getEntrySection.accessPointElevator;
            // this.show__accessPoint_addEdit_block=this.$store.getters.getEntrySection.addEditAccessPoint;
            this.show__accessPoint_addEdit_block=true;
            
            this.detailsEntry.id=this.elevatorDetails.entry_id;
            this.getVersion();
        },

        mounted() {
            
        },

        watch: {
            versionAccessPoint:function() {
                console.log('fsdf');
                this.active_relay=false;
                this.active_relationRelays=false;
                this.active_SaveAccessPoint=false;
                this.btnConfigRelays=true;
            },
        },

        computed: {

        },

        methods: {
            show__info_address : function() {

                 this.show__address_block = !this.show__address_block;
            },

            show__info_accessPoint: function() {
                this.show__accessPoint_block = !this.show__accessPoint_block;
                console.log (this.$store.getters.getUser);
            },

            show__info_accessPoint_addEdit: function() {

                this.show__accessPoint_addEdit_block = !this.show__accessPoint_addEdit_block;
            },

            addElevator: function() {
                this.$http.post(`/addElevator`,this.elevatorDetails)
                .then(response => {
                    console.log(response.data);
                    this.clearElevator();
                })
                .catch(e => {
                    console.log(e);
                });
            },

            clearElevator: function() {
                this.elevatorDetails.identifier=null;
                this.elevatorDetails.type=null;
                this.elevatorDetails.company=null;
                this.elevatorDetails.madeIn=null;
            },

            clearRelay: function() {
                this.relayName=null;
                this.relayfloor=null;
                this.relayPulsTime=null;
            },

            getVersion: function() {
                this.$http.get(`/getVersions`)
                .then(response => {
                    this.versions=response.data;
                    this.accessPoints.version=this.versions[0];
                    this.chooseVersion();
                })
                .catch(e => {
                    console.log(e);
                });
            },

            getBuilding: function() {
                // this.$http.get(`/getVersions`)
                // .then(response => {
                //     this.versions=response.data;
                // })
                // .catch(e => {
                //     console.log(e);
                // });

            },

            chooseVersion:function() {
                this.relays = [];
                this.accessPoints.versionId=this.accessPoints.version.id;
                this.numberOfRelays=this.accessPoints.version.number_of_relays;
                this.relayName=null;

                for( var i=1 ; i<=this.numberOfRelays ; i++) {
                    this.relays[i]={
                        access_point_id:null,
                        relay:null,
                        floor:null,
                        pulse_time:null,
                    };
                }

                this.versionAccessPoint=this.accessPoints.version.name;
                console.log(this.accessPoints.version.name);
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

            setRelationRelays: function() {
                this.$http.post(`/relationRelays`,this.access_points.id)
                .then(response => {
                    console.log(response.data);
                    //get 
                    this.relationRelays=response.data;

                })
                .catch(e => {
                    console.log(e);
                });
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
                this.setRelayDetails(this.index);
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
                this.setRelayDetails(this.index);

            },

            configRelays:function() {
                this.active_relay=true;
                this.active_relationRelays=true;
                this.active_SaveAccessPoint=true;
                this.btnConfigRelays=false;

                this.relayName = "Relay " + this.index;
            }
        },
    }
</script>

<template src="./templates/entry_details.html">

</template>

<style>
	
</style>