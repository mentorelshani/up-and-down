<script>
    export default {
        data() {
            return {
                clients:{},
                details:{
                    apartment:{},
                    entry_id:null,
                    gender:null,
                },
                modal:{
                    title:null,
                    btnEdit:false,
                    btnAdd:false,
                },
                apartments:{},

                showInputOther:false,
                showSelectOther:true,

                 error:{
                    door_number:null,
                    birthday:null,
                    email:null,
                    firstname:null,
                    gender:null,
                    lastname:null,
                    phone_number:null,
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
                this.getApartment();
                this.details.entry_id=this.entryId;
            },
        },

        methods:{
            getAll:function() {
                this.$http.get('/getClients/'+this.entryId)
                    .then(response => {
                        this.clients=response.data;
                    })
                    .catch(e => {
                        console.log(e.body);
                    });
            },

            add:function() {
                this.$http.post('/addClient',this.details)
                    .then(response => {
                        console.log("Klienti u regjistrua me sukses = !false");
                        this.error={};
                        this.getAll();
                    })
                    .catch(e => {
                        console.log("Klienti u regjistrua me sukses = false");
                        this.error=e.body;
                    });
            },

            edit:function() {
                this.$http.post('/updateClient',this.details)
                    .then(response => {
                        console.log("Klienti u përditsua me sukses = !false");
                        this.error={};
                        this.getAll();
                    })
                    .catch(e => {
                        console.log("Klienti u përditsua me sukses = false");
                        this.error=e.body;
                    });
            },

            destroy:function(idClient) {
                this.$http.delete(`/deleteClient/`+idClient)
                    .then(response => {
                        console.log("Klienti u fshi me sukses = !false");
                        this.getAll();
                    })
                    .catch(e => {
                        console.log("Klienti u fshi me sukses = false");
                        console.log(e.body);
                    });
            },

            getDetails:function(idClient) {
                this.$http.get(`/getClient/`+idClient)
                    .then(response => {
                        this.details=response.data;
                    })
                    .catch(e => {
                        console.log(e.body);
                    });
            },

            getApartment:function() {
                this.$http.get(`/getApartments/`+this.entryId)
                    .then(response => {
                        this.apartments=response.data;
                    })
                    .catch(e => {
                        console.log(e.body);
                    })
            },

            otherOptionApartment:function() {
                console.log('fsdfsd');
                this.showInputOther= !this.showInputOther;
                this.showSelectOther= !this.showSelectOther;
            },

            modalAdd:function() {
                this.clearDetails();

                this.modal.title="Add new client!";
                this.modal.btnAdd=true;
                this.modal.btnEdit=false;
            },

            modalEdit:function(firstname,lastname) {
                this.modal.title="Edit client: "+ firstname +" "+ lastname;
                this.modal.btnAdd=false;
                this.modal.btnEdit=true;
            },

            clearDetails:function() {
                this.details.apartment={};
                this.details.door_number=null;
                this.details.birthday=null;
                this.details.created_at=null;
                this.details.email=null;
                this.details.firstname=null;
                this.details.gender=null;
                this.details.id=null;
                this.details.lastname=null;
                this.details.phone_number=null;
                this.details.type=null;
                this.details.updated_at=null;
            },
        },
    }

</script>

<template src="./templates/clients.html">
</template>
