<script>
    export default {
        data() {
            return {
                accessPoints:{},

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

            // add:function() {
            //     this.$http.post('/addAccessPoint',this.details)
            //         .then(response => {
            //             console.log(response.data);
            //         })
            //         .catch(e => {
            //             console.log(e);
            //         });
            // },

            // edit:function() {
            //     this.$http.post('/updateAccessPoint',this.details)
            //         .then(response => {
            //             console.log(response.data);
            //         })
            //         .catch(e => {
            //             console.log(e);
            //         });
            // },

            destroy:function(idAccessPoint) {
                this.$http.delete(`/deleteAccessPoint/`+idAccessPoint)
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

<template src="./templates/accessPoints.html">
</template>

