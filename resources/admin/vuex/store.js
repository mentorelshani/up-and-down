import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const entryModule = {
    state: {
        entrySection:{},
    },
    getters: {
        getEntrySection: state => {
            return state.entrySection;
        },
    },  
        
    mutations: {
        setEntrySection(state,showSection){
            state.entrySection['address']=showSection.address;
            state.entrySection['accessPointElevator']=showSection.accessPointElevator;
            state.entrySection['addEditAccessPoint']=showSection.addEditAccessPoint;
        }
    },
}

const mainModule = {
    subStore: 'main',
    prefix: 'main/',
    state: {
        paginatePage:null,
        showItem:null,
    },

    getters: {
        getPaginatePage: state => {
            return state.paginatePage;
        },
        getShowItem: state => {
            return state.showItem;
        },
    },  

    mutations: {
        setShowItem(state,showItem){
            state.showItem=showItem;
        },

        setPaginatePage(state,paginatePage){
            state.paginatePage=paginatePage;
        },
    },
}


export const store=new Vuex.Store({
    modules: {
        entry:entryModule,
        main:mainModule,
    }
})
