import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex);
export default new Vuex.Store({
	state: {
		user:null,
		auth:false,
	},
	mutations: {
		SET_USER(state,user){
			state.user=user;
			state.auth=true;
		},
		SET_TITLE(state,title)
		{
			document.title=title+' - Picture gallery';
		},
		LOGOUT(state) 
		{
        	localStorage.removeItem('id_token')
        	state.user = null;
        	state.auth = false;
        }
	},
	actions: {
		login({commit},user){
			return new Promise((resolve,reject)=>{
				Vue.http.post('/signin',user).then(function(response){
            		localStorage.setItem('id_token', response.data.meta.token)
            		Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('id_token')
            		commit('SET_USER',response.data.data);
	  				resolve();
	  			},function(err){
	  				console.log(err);
	  				reject();
	  			})				
			})

		},
		register({commit}, user) {
			return new Promise((res,rej)=>{
       			Vue.http
       			.post('/register',user)
        	    .then(response => {
        	    	res();
        		}, response => {
        			rej();		    
      		  	})				
			})
    	},
		checkAuth({commit})
		{
			if (localStorage.getItem('id_token') !== null) {
            	Vue.http
            	.get('/user')
            	.then(response => {
            		commit('SET_USER',response.data.data)
            	})
        	}
		},
		logout({commit}){
			commit('LOGOUT')
		},
		setTitle({commit},title){
			commit('SET_TITLE',title);
		},
	},
	getters: {
    	user: state => state.user,
	}
})