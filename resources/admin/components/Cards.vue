<script>
    export default {
        data() {
            return {
                cards:{},
                details:{},

                error:{},
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
        },

        mounted() {
        },

        computed: {
        },

        watch: {
        },

        methods: {
            getAll:function() {
                this.$http.get('/getCards/'+this.entryId)
                    .then(response => {
                        this.cards=response.data;
                    })
                    .catch(e => {
                        console.log(e.body);
                    });
            },

            add:function() {
                this.$http.post('/addCard',this.details)
                    .then(response => {
                        console.log(this.details);
                        console.log("Card u regjistrua me sukses = !false");
                        this.error={};
                        this.getAll();
                    })
                    .catch(e => {
                        console.log("Klienti u regjistrua me sukses = false");
                        console.log(e.body);
                        this.error=e.body;
                    });
            },

            edit:function() {
                this.$http.post('/updateCard',this.details)
                    .then(response => {
                        console.log("Klienti u përditsua me sukses = !false");
                        this.error={};
                        this.getAll();
                    })
                    .catch(e => {
                        console.log("Klienti u përditsua me sukses = false");
                        console.log(e.body);
                        this.error=e.body;
                    });
            },

            destroy:function(idCard) {
                this.$http.delete(`/deleteClard/`+idCard)
                    .then(response => {
                        console.log("Klienti u fshi me sukses = !false");
                        this.getAll();
                    })
                    .catch(e => {
                        console.log("Klienti u fshi me sukses = false");
                        console.log(e.body);
                    });
            },

            getDetails:function(idCard) {
                this.$http.get(`/getClient/`+idCard)
                    .then(response => {
                        this.details=response.data;
                    })
                    .catch(e => {
                        console.log(e.body);
                    });
            },

            modalAdd:function() {
                this.modal.title="Add new card!";
                this.modal.btnAdd=true;
                this.modal.btnEdit=false;
            },

            modalEdit:function() {
                this.modal.title="Edit card!";
                this.modal.btnAdd=false;
                this.modal.btnEdit=true;
            },
        }
    }

</script>

<template src="./templates/cards.html">
</template>
