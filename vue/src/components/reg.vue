<template>
	<div class="row">
		<div class="col-md-5">	
			<div v-if="notReg" class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Oh snap!</strong> {{notReg}}
			</div>
			<form class="form-horizontal">
				<div class="form-group" :class="{'has-error': errors.has('name') }">
					<label for="name" class="col-sm-2 control-label">Name</label>
					<div class="col-sm-10">
						<input
							v-model="loginU.name" type="text" class="form-control" name="name" data-vv-rules="required" v-validate>
						<p class="text-danger" v-if="errors.has('name')">
							{{errors.first('name')}}
						</p>
					</div>
				</div>
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
						<button @click.prevent="reg" type="submit" class="btn btn-success">Reg</button>
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
    				password:'',
    				name:''
    			},
    			notReg:null
    		};
  		},
  		methods:{
  			reg()
  			{
  				let self=this;
  				this.$store.dispatch('register',this.loginU).then(()=>{
  					self.$store.dispatch('login',this.loginU).then(()=>{
  						console.log('good auth from reg');
  					},()=>{
  						console.log('err auth from reg');
  					})
  				},(res)=>{
  					this.notReg=res.error;
  				})
  			}
  		},
  		created(){
  		}
	};
</script>

<style lang="css" scoped>

</style>		