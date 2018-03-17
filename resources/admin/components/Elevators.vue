<script>
    import alert from '../components/service/sweetAlert.js'

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

                error:{
                    identifier:null,
                    type:null,
                    made_in:null,
                    company:null
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
                        this.getAll();
                        this.error={};
                        swal({ title:"Success!", text:null, type:"success" });
                                            })
                    .catch(e => {
                        console.log(e.body);
                        this.error=e.body;
                        swal({ title:"Error!", text:'This row has not been added!', type:"error" });
                    });
            },

            edit:function() {
                let vm=this;

                alert.modify(function() {
                    vm.$http.post('/updateElevator',vm.details)
                        .then(response => {
                            vm.getAll();
                            vm.error={};
                        })
                        .catch(e => {
                            swal({ title:"Error!", text:'This row has not been updated!', type:"error" });
                            vm.error=e.body;
                        });
                });
            },

            getDetails:function(idElevator) {

                this.error={};
                
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
                let vm=this;

                alert.delete(function() {
                    vm.$http.delete(`/deleteElevator/`+idElevator)
                        .then(response => {
                            vm.getAll();
                        })
                        .catch(e => {
                            alert.information("Error",'This row has not been removed!',"error");
                        });
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
