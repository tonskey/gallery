<template>
	<div class="row">
		<div class="col-md-5">	
			<div v-if="notAuth" class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Oh snap!</strong> {{notAuth}}
			</div>
			<form class="form-horizontal">
				<div class="form-group" :class="{'has-error': errors.has('email') }">
					<label for="email" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
						<input
							v-model="loginU.email" type="email" class="form-control" name="email" data-vv-rules="required" v-validate>
						<p class="text-danger" v-if="errors.has('email')">
							{{errors.first('email')}}
						</p>
					</div>
				</div>
				<div class="form-group" :class="{'has-error': errors.has('password') }">
					<label for="password" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10">
						<input v-validate data-vv-rules="required" name="password" v-model="loginU.password" type="password" class="form-control">
						<p class="text-danger" v-if="errors.has('password')">
							{{errors.first('password')}}
						</p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button @click.prevent="login" type="submit" class="btn btn-default">Log in</button>
					</div>
				</div>
			</form>
		</div>	
	</div>
</template>
<script>
	export default {
		name: 'login',
		data () {
    		return {
    			loginU:{
    				email:'',
    				password:''
    			},
    			notAuth:null
    		};
  		},
  		methods:{
  			login()
  			{
  				this.$store.dispatch('login',this.loginU).then(function(){
  					console.log('good');
  				},(res)=>{
  					this.notAuth=res.data.error;
  				});
  			}
  		},
  		created(){
  		}
	};
</script>

<style lang="css" scoped>

</style>		