<script>
    export default {
        data() {
            return {
                clients:{},
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
                console.log('u ndryshua Id e hyrjes');
            }
        },

        methods:{
            getAll:function() {
                this.$http.get('/getClients/'+this.entryId)
                    .then(response => {
                        this.clients=response.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            add:function() {
                // this.$http.post('/addEntry',this.details)
                //     .then(response => {
                //         console.log(response.data);
                //     })
                //     .catch(e => {
                //         console.log(e);
                //     });
            },

            edit:function(idClient) {
                console.log(idClient);
                // this.$http.post('/updateEntry',this.details)
                //     .then(response => {
                //         console.log(response.data);
                //     })
                //     .catch(e => {
                //         console.log(e);
                //     });
            },

            destroy:function(idClient) {
                this.$http.delete(`/deleteClient/`+idClient)
                .then(response => {
                    console.log('U fshi me sukses');
                    this.getAll();
                })
                .catch(e => {
                    console.log(e.respone);
                });
            } 
        },
    }

</script>

<template src="./templates/clients.html">
</template>

