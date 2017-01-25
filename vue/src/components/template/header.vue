<template>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li>
						<router-link :to="{name:'home'}">
							<span class="glyphicon glyphicon-home"></span>
							Home
						</router-link>	
					</li>
				</ul>	
				<ul class="nav navbar-nav navbar-right">
					<template v-if="!user">
					<li>
						<router-link :to="{name:'login'}">
							<span class="glyphicon glyphicon-log-in"></span>
							Login
						</router-link>	
					</li>
					<li>
						<router-link :to="{name:'reg'}">
							<span class="glyphicon glyphicon-log-in"></span>
							Reg
						</router-link>	
					</li>
					</template>
					<template v-else>
						<li>
							<p class="navbar-text">
								{{user.name}}
							</p>
						</li>
						<li>
							<router-link :to="{name:'create'}">
								<span class="glyphicon glyphicon-add"></span>
								Create picture
							</router-link>
						</li>
						<li>
							<a href="#" @click.prevent="logout">
								<span class="glyphicon glyphicon-log-out"></span>
								logout
							</a>	
						</li>
					</template>
				</ul>
			</div>
		</div>
	</nav>
</template>
<script type="text/javascript">
	export default {
		name:'header',	
		computed:{
			user(){
				return this.$store.getters.user;
			},
		},
		methods:{
			logout()
			{
				this.$store.dispatch('logout')
			}
		}
	}
</script>
<style type="text/css" scoped>
	.navbar{
		background-color: #31708f;
	}
	.navbar-default .navbar-nav > li > a {
		color: white;
	}
	.navbar-default .navbar-nav > li > a:hover {
		background-color: #145271;
	}
	.navbar-text{
		color:#ffffff;
	}
</style>