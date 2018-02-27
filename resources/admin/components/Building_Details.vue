<script>
    export default {
        data: function() {
            return {
             
                idBuilding:null,
                idEntry:null,
                detailsBuilding:null,
                elevatorDetails:{},

                buildings:{},

                detailsEntry: {},

                modalEntry: {
                    title:null,
                    btnEdit:null,
                    btnAdd:null,
                },

                show_info:true,

                error_entry:{
                    building_id:null,
                    name:null,
                    number_of_apartments:null,
                    number_of_floors:null,
                },
                
                showDetailsBuilding:false,
            }
        },

        beforeCreate() {

        },

        created() {
            this.idBuilding=this.$route.params.id;
            this.getAllBuilding();

        },

        mounted() {
            this.getBuildingDetails(this.idBuilding);
        },

        watch: {
            detailsBuilding:function() {
                // this.getBuildingDetails(this.idBuilding);
            },
        },

        computed: {

        }, 

        methods: {
            getBuildingDetails:function(param) {
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

            getAllBuilding:function() {
                this.detailsEntry.building_id=parseInt(this.$route.params.id);
                this.$http.get(`/getExistingAddresses`)
                .then(response => {
                    this.buildings=response.data.buildings;
                })
                .catch(e => {
                    console.log(e);
                });
            },

            getEntryDetails:function(entryId) {
                this.idEntry=entryId;
                console.log(entryId);
                this.$http.get(`/getEntry/`+entryId)
                .then(response => {
                    this.detailsEntry=response.data;
                })
                .catch(e => {
                    console.log(e.body);
                });
            },
            
            addEntry:function() {

                this.$http.post(`/addEntry`,this.detailsEntry)
                .then(response => {
                    this.getBuildingDetails(this.idBuilding);
                    this.clearDetailsEntry();
                    console.log("Klienti u shtua me sukses = !false");
                    this.error_entry={}; 
                })
                .catch(e => {
                    console.log(e.body);
                    this.error_entry=e.body;
                });
            },

            clearDetailsEntry:function(){
                this.detailsEntry.building_id=null;
                this.detailsEntry.name= null;
                this.detailsEntry.number_of_floors=null;
                this.detailsEntry.number_of_apartments= null;
            },

            modalAdd:function() {
                this.detailsEntry={};
                this.detailsEntry.building_id=parseInt(this.$route.params.id);

                this.modalEntry.title="Add new Entry!";
                this.modalEntry.btnAdd=true;
                this.modalEntry.btnEdit=false;
            },

            modalEdit:function(name) {
                this.modalEntry.title="Edit entry: "+ name;
                this.modalEntry.btnAdd=false;
                this.modalEntry.btnEdit=true;
            },

            setMenu: function(top, left) {
                largestHeight = window.innerHeight - this.$$.right.offsetHeight - 25;
                largestWidth = window.innerWidth - this.$$.right.offsetWidth - 25;

                if (top > largestHeight) top = largestHeight;

                if (left > largestWidth) left = largestWidth;

                this.top = top + 'px';
                this.left = left + 'px';
            },

            closeMenu: function() {
                this.viewMenu = false;
            },

            openMenu: function(e) {
                this.viewMenu = true;

                Vue.nextTick(function() {
                    this.$$.right.focus();

                    this.setMenu(e.y, e.x)
                }.bind(this));
                e.preventDefault();
            },

        },
    }
</script>

<template src="./templates/building_details.html">

</template>

<style>
    
</style>