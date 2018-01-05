<script>
    export default {
        data() {
            return {
            	elevators:{},
                details:{
                    entry_id:null,
                },
            }
        },

        props: {
            entryId:null,
        },

        beforeCreate() {

        },

        created() {
            this.getAll();
            this.details.entry_id=this.entryId;
        },

        mounted() {
   
        },

        computed: {

        },

        watch: {
           	entryId:function() {
                this.getAll();
                console.log('u ndryshua Id e hyrjes');
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
            
            addForm:function(){
                this.clearDetails();
            },
            
            clearDetails:function(){
                this.details={};
            },
        },
    }

</script>

<template src="./templates/elevators.html">
</template>

