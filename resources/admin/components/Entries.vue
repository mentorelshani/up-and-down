<script>
    export default {
        data: function() {
            return {
                entriesSite: [],
                setEntries: null,
                setLengthEntries: null,

                //data for list of entries
                showItems: "20",
                paginatePage: 1,
                keySearch: ['buildings.name'],
                inputSearch: null,
                ascending: true,
                orderBy: 'buildings.name',
            }
        },
        beforeCreate() {},

        created() {
            this.$store.watch(
                (state) => {
                    return this.$store.getters.getShowItem
                }, (val) => {
                    this.showItems = this.$store.getters.getShowItem;
                    this.Entries();
                });

            this.$store.watch(
                (state) => {
                    return this.$store.getters.getPaginatePage
                }, (val) => {
                    this.paginatePage = this.$store.getters.getPaginatePage;
                    this.Entries();
                });
        },
        mounted() {
            this.Entries();
        },

        computed: {
            objEntries: function() {
                return this.setEntries;
            },
        },

        watch: {
            keySearch: function() {
                this.inputSearch = null;
                this.paginatePage = 1;
                this.Entries();
            },
            showItems: function() {
                this.paginatePage = 1;
                this.Entries();
            },

        },

        methods: {
            Entries: function() {
                this.entriesSite = {
                    limit: this.showItems,
                    page: this.paginatePage,
                    relation: this.keySearch,
                    value: this.inputSearch,
                    asce: this.ascending,
                    orderBy: this.orderBy,
                };

                this.$http.post(`/getEntries1`, this.entriesSite)
                    .then(response => {
                        this.setEntries = response.data.data;
                        this.setLengthEntries = response.total;

                        // this.pagination.current_page=response.data.current_page;
                        // this.pagination.from=response.data.from;
                        // this.pagination.last_page=response.data.last_page;
                        // this.pagination.per_page=response.data.per_page;
                        // this.pagination.to=response.data.to;
                        // this.pagination.total=response.data.total;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            addEntry:function() {
                console.log('addForm');
                // router.go('/entry');
                // route.push('entry');
                // routes.push({ path: 'home' })

                this.$store.commit('setEntrySection', {
                    address:true,
                    accessPointElevator:false,
                    addEditAccessPoint:false,
                });
            },

            editEntry: function(paramId) {
                console.log(paramId);

                this.$store.commit('setEntrySection', {
                    address:true,
                    accessPointElevator:false,
                    addEditAccessPoint:true,
                });
            },

            deleteEntry: function(paramId) {
                console.log(paramId);
                this.$http.delete(`/deleteEntry/`+paramId)
                .then(response => {
                    console.log('U fshi me sukses');
                    this.Entries();
                })
                .catch(e => {
                    console.log(e.respone);
                });
            },

            Sort: function(orderBy, ascending) {
                if (this.orderBy == orderBy) {

                    if (this.ascending != ascending) {
                        this.orderBy = orderBy;
                        this.ascending == ascending;
                    } else {
                        this.orderBy = orderBy;
                        this.ascending = !ascending;
                    }

                } else if (this.orderBy != orderBy) {

                    this.orderBy = orderBy;
                }
                this.Entries();
            },

            changeSearchKey:function(searchKey) {
                console.log(searchKey);
                this.keySearch=[];

                if(searchKey=="anything") {
                    this.keySearch=['buildings.name','entry.name','cities.name','addresses.street','IMEI'];
                } 
                else {
                    this.keySearch=[searchKey];
                }
            },
        },
    }
</script>

<template src="./templates/entries.html">
</template>

<style>
</style>