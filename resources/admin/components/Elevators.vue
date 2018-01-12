<script>
    export default {
        data() {
            return {
            	elevators:{},
                details:{
                    entry_id:null,
                },

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
            this.clearDetails();
        },

        mounted() {
   
        },

        computed: {

        },

        watch: {
           	entryId:function() {
                this.getAll();
                this.details.entry_id=this.entryId;

            }
        },

        methods:{
            getAll:function() {
                this.$http.get('/getElevators/'+this.entryId)
                    .then(response => {
                        this.elevators=response.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            add:function() {
                this.details.entry_id=this.entryId;
                this.$http.post('/addElevator',this.details)
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            edit:function() {
                this.$http.post('/updateElevator',this.details)
                    .then(response => {
                        console.log(response.data);
                        this.getAll();
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            getDetails:function(idElevator) {
                console.log('asd');
                this.$http.get(`/getElevator/`+idElevator)
                .then(response => {
                    this.details=response.data;
                    this.getAll();
                })
                .catch(e => {
                    console.log(e.respone);
                });
            },

            destroy:function(idElevator) {
                this.$http.delete(`/deleteEntry/`+idElevator)
                .then(response => {
                    console.log('U fshi me sukses');
                    this.getAll();
                })
                .catch(e => {
                    console.log(e.respone);
                });
            },

            modalAdd:function() {
                this.clearDetails();

                this.modal.title="Add new elevator!";
                this.modal.btnAdd=true;
                this.modal.btnEdit=false;
            },

            modalEdit:function(identifier) {
                this.modal.title="Edit elevator: "+ identifier;
                this.modal.btnAdd=false;
                this.modal.btnEdit=true;
            },
            
            clearDetails:function(){

                this.details.company=null;
                this.details.created_at=null;
                this.details.entry_id=null;
                this.details.id=null;
                this.details.identifier=null;
                this.details.made_in=null;
                this.details.type=null;
                this.details.updated_at=null;
            },
        },
    }

</script>

<template src="./templates/elevators.html">
</template>

