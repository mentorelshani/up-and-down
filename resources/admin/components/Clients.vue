<script>
    import alert from '../components/service/sweetAlert.js'

    export default {
        data() {
            return {
                clients:{},
                details:{
                    apartment:{},
                    entry_id:null,
                    gender:null,
                    entry_id:null
                },

                clientsSite:{},

                show__items:"20",
                paginate__page:1,
                keySearch:["clients.firstname","clients.lastname"],
                inputSearch:null,
                ascending:true,
                orderBy:'clients.firstname',

                pagination:{},

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

                searchBy:'Filter by',
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
            keySearch: function() {
                this.inputSearch=null;
                this.paginate__page=1;
                this.getAll();
            },

            show__items: function() {
                this.paginate__page=1;
                this.getAll();
            },

            entryId:function(){
                this.getAll();
                this.getApartment();
                this.details.entry_id=this.entryId;
                
                this.$store.watch(
                    (state)=>{
                        return this.$store.getters.getShowItem
                    },
                    (val)=>{
                        this.show__items=this.$store.getters.getShowItem;
                        this.getAll();
                    });

                this.$store.watch(
                    (state)=>{
                        return this.$store.getters.getPaginatePage
                    },
                    (val)=>{
                        this.paginate__page=this.$store.getters.getPaginatePage;
                        this.getAll();
                    });
            },
        },

        methods:{
            getAll:function() {
                this.clientsSite={
                    limit:this.show__items,
                    page:this.paginate__page,
                    relation:this.keySearch,
                    value:this.inputSearch,
                    asce:this.ascending,
                    orderBy:this.orderBy, 
                };   

                this.$http.post('/getClients/'+this.entryId,this.clientsSite)
                    .then(response => {
                        this.clients=response.data.data;

                        this.dataLength=response.data.total;
                        
                        this.pagination.current_page=response.data.current_page;
                        this.pagination.from=response.data.from;
                        this.pagination.last_page=response.data.last_page;
                        this.pagination.per_page=response.data.per_page;
                        this.pagination.to=response.data.to;
                        this.pagination.total=response.data.total;
                    })
                    .catch(e => {
                        console.log(e.body);
                    });
            },

            add:function() {
                this.$http.post('/addClient',this.details)
                    .then(response => {
                        swal({ title:"Success!", text:null, type:"success" });
                        
                        this.error={};
                        this.getAll();
                    })
                    .catch(e => {
                        swal({ title:"Error!", text:'This row has not been added!', type:"error" });
                        this.error=e.body;
                    });
            },

            edit:function() {
                let vm=this;

                alert.modify( function() {
                     vm.$http.post('/updateClient',vm.details)
                        .then(response => {
                            vm.error={};
                            vm.getAll();
                        })
                        .catch(e => {
                            swal({ title:"Error!", text:'This row has not been updated!', type:"error"});
                            vm.error=e.body;
                        });
                });              
            },

            destroy:function(idClient) {
                let vm=this;

                alert.delete(function() {
                    vm.$http.delete(`/deleteClient/`+idClient)
                        .then(response => {
                            vm.getAll();
                        })
                        .catch(e => {
                            swal('Deleted!','This row has not been removed!','error');
                        });
                })          
            },

            getDetails:function(idClient) {
                this.$http.get(`/getClient/`+idClient)
                    .then(response => {
                        this.details=response.data;
                        this.details.door_number=response.data.apartment.door_number;
                        this.details.entry_id=this.entryId;

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

             changeSearchKey:function(searchKey) {
                this.keySearch=[];
                console.log(searchKey);
                
                if(searchKey=="everything") {
                    this.keySearch=['clients.firstname','clients.lastname','clients.email','clients.phone_number'];
                    this.searchBy="Everything";
                }
                else if(searchKey=="client") {
                    this.keySearch=['clients.firstname','clients.lastname'];
                    this.searchBy="Client";
                }
                else {
                    this.keySearch=[searchKey];
                    if(searchKey=="clients.email") {
                        this.searchBy="Email";
                    }

                    if(searchKey=="clients.phone_number") {
                        this.searchBy="Phone number";
                    }
                }
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
