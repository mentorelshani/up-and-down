<script>
    export default {
        data() {
            return {
            	elevators:{},
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
                this.$http.get('/getElevators/'+this.entryId)
                    .then(response => {
                        this.elevators=response.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            // add:function() {
            //     this.$http.post('/addEntry',this.details)
            //         .then(response => {
            //             console.log(response.data);
            //         })
            //         .catch(e => {
            //             console.log(e);
            //         });
            // },

            // edit:function() {
            //     this.$http.post('/updateEntry',this.details)
            //         .then(response => {
            //             console.log(response.data);
            //         })
            //         .catch(e => {
            //             console.log(e);
            //         });
            // },

            destroy:function(idElevator) {
                this.$http.delete(`/deleteEntry/`+idElevator)
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

<template src="./templates/elevators.html">
</template>

